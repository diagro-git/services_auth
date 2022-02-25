<?php
namespace App\Services;

use App\Models\Company;
use App\Models\FrontendApplication;
use App\Models\User;
use Carbon\Carbon;
use Diagro\Token\ApplicationAuthenticationToken;
use Diagro\Token\AuthenticationToken;
use Diagro\Token\Model\Application;
use Diagro\Token\Model\Permission;
use Diagro\Token\Token;
use Exception;
use Firebase\JWT\ExpiredException;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\Token as TokenModel;
use Throwable;
use function request;

class TokenService
{


    /**
     * Create an AT token based on the provided user.
     *
     * @param User $user
     * @return AuthenticationToken
     * @throws Throwable
     */
    public function createAT(User $user) : AuthenticationToken
    {
        $tu = new \Diagro\Token\Model\User($user->id, $user->name, $user->locale()->first()->identifier, $user->language()->first()->iso_639_2, $user->timezone()->first()->name);
        $at = new AuthenticationToken($tu, $this->issuer(), $this->device());
        $this->saveToken($at, $user->id);

        return $at;
    }


    /**
     * Get the device name of the request.
     *
     * @return string
     */
    private function device() : string
    {
        return request()->userAgent() ?? 'Unknown';
    }


    /**
     * Get the issuer, which is the frontend application id
     *
     * @return string
     * @throws BindingResolutionException
     */
    private function issuer() : string
    {
        return (string) app()->make(FrontendApplication::class)->id;
    }


    /**
     * Create a token object from a given token string.
     *
     * @param string $token_class_name
     * @param string $token
     * @return Token
     * @throws Throwable
     */
    public function createToken(string $token_class_name, string $token) : Token
    {
        try {
            $at = $token_class_name::createFromToken($token);
        } catch(ExpiredException $ee) {
            $this->expireToken($token);
            throw $ee;
        } catch(Exception $e) {
            $this->revokeToken($token, $e->getMessage());
            throw $e;
        }

        return $at;
    }


    /**
     * Check if a token string is valid or not.
     * Checks is the token exists in the database,
     * or if it's expired or revoked.
     *
     * @param string $token
     * @return true|string
     */
    public function isValid(?string $token): bool|string
    {
        if($token == null) return false;
        $valid = true;

        $model = TokenModel::query()->where('token', '=', $token)->first();
        if($model == null || ! ($model instanceof TokenModel)) {
            $valid = 'Token not found!';
        } elseif($model->status == TokenModel::STATUS_EXPIRED) {
            $valid = 'Token is expired!';
        } elseif($model->status == TokenModel::STATUS_REVOKED) {
            $valid = 'Token is revoked (' . $model->revoked_reason . ')';
        }

        return $valid;
    }


    /**
     * Expire a given token in the tokens table..
     *
     * @param string $token
     * @throws Throwable
     */
    private function expireToken(string $token)
    {
        TokenModel::query()
            ->where('token', '=', $token)
            ->update(['status' => TokenModel::STATUS_EXPIRED]);
    }


    /**
     * Save the token in the tokens table.
     *
     * @param Token $token
     * @param int $user_id
     * @throws Throwable
     */
    private function saveToken(Token $token, int $user_id)
    {
        $model = new TokenModel();
        $model->user_id = $user_id;
        $model->token_type = ($token instanceof AuthenticationToken ? TokenModel::TOKEN_TYPE_AT : TokenModel::TOKEN_TYPE_AAT);
        $model->status = TokenModel::STATUS_ACTIVE;
        $model->token = $token->token();
        $model->issuer = $this->issuer();
        $model->device = $this->device();
        $model->saveOrFail();
    }


    /**
     * Revoke the tokens of the user who are not revoked
     *
     * @param User $user
     * @param User $revoked_by
     * @param string $reason
     * @return int How much tokens are revoked.
     */
    public function revokeTokens(User $user, User $revoked_by, string $reason) : int
    {
        return $user->tokens()
            ->where('status', '=', TokenModel::STATUS_ACTIVE)
            ->update(['status' => TokenModel::STATUS_REVOKED, 'revoked_by' => $revoked_by->id, 'revoked_reason' => $reason, 'deleted_at' => Carbon::now()]);
    }


    /**
     * Revoke a token.
     *
     * @param string $token
     * @param string $reason
     * @return int
     */
    public function revokeToken(string $token, string $reason)
    {
        return TokenModel::query()
            ->where('token', '=', $token)
            ->update(['status' => TokenModel::STATUS_REVOKED, 'revoked_reason' => $reason, 'deleted_at' => Carbon::now()]);
    }


    /**
     * Get an AAT token that isn't expired for given AT token.
     *
     * @param AuthenticationToken $at
     * @return ApplicationAuthenticationToken|null
     */
    public function getValidAAT(AuthenticationToken $at): ?ApplicationAuthenticationToken
    {
        $aat = null;
        $token = TokenModel::query()
            ->where([
                'token_type' => 'AAT',
                'issuer' => $this->issuer(),
                'device' => $this->device(),
                'status' => 0,
                'user_id' => $at->user()->id()
            ])->first();

        if($token != null) {
            try {
                $aat = ApplicationAuthenticationToken::createFromToken($token->token);
            } catch(Exception $e) {
                $this->revokeToken($token->token, 'getValidAAT could not createFromToken!');
            }
        }

        return $aat;
    }


    /**
     * Create an AAT token based from an AT token and the choosen company.
     * The applications are the applications linked to the frontend application.
     *
     * @param AuthenticationToken $at
     * @param Company $company
     * @return ApplicationAuthenticationToken
     * @throws BindingResolutionException|Throwable
     */
    public function createAAT(AuthenticationToken $at, Company $company) : ApplicationAuthenticationToken
    {
        $aat = $this->getValidAAT($at);

        if($aat == null) {
            $tu = new \Diagro\Token\Model\User($at->user()->id(), $at->user()->name(), $at->user()->locale(), $at->user()->lang(), $at->user()->timezone());
            $tc = new \Diagro\Token\Model\Company($company->id, $company->name, $company->country()->first()->iso_3166_1, $company->currency()->first()->iso_4217);
            /** @var User $user */
            $user = User::query()->findOrFail($tu->id());
            /** @var FrontendApplication $frontend */
            $frontend = app()->make(FrontendApplication::class);

            //role of the user in the company
            $role = $company->pivot->role()->first();
            $tu->role($role->name);

            //applications where user/company has rights
            $applications = [];
            foreach ($frontend->applications()->get() as $app) {
                $application = new Application($app->id, $app->name);
                $rights = $user->rights($company, $app);
                foreach ($rights as $name => $permissions) {
                    $p = new Permission();
                    $p->canRead($permissions['r'])
                        ->canCreate($permissions['c'])
                        ->canUpdate($permissions['u'])
                        ->canDelete($permissions['d'])
                        ->canPublish($permissions['p'])
                        ->canExport($permissions['e']);
                    $application->addPermission($name, $p);
                }

                //only add applications where user has permissions with
                if (count($application->permissions()) > 0) {
                    $applications[] = $application;
                }
            }

            $aat = new ApplicationAuthenticationToken($tu, $tc, $applications, $this->issuer(), $this->device());
            $this->saveToken($aat, $user->id);
        }

        return $aat;
    }


}
