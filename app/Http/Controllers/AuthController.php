<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\FrontendApplication;
use App\Models\User;
use App\Services\TokenService;
use Diagro\Token\AuthenticationToken;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{


    /**
     * Login the user by email/password or by sending the AT token in the header.
     *
     * @param Request $request
     * @param TokenService $service
     * @return array
     * @throws BindingResolutionException|Throwable
     */
    public function login(Request $request, TokenService $service)
    {
        //has AT token?
        if(($token = $request->bearerToken()) != null) {
            $valid = $service->isValid($token);
            if ($valid !== true) abort(406, $valid);

            $at = app(AuthenticationToken::class);
            $user = $request->user();
        } else {
            //validate request for username/password
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            $provider = Auth::createUserProvider('users');
            /** @var User $user */
            $user = $provider->retrieveByCredentials($data);
            if($user == null || ! $provider->validateCredentials($user, $data)) {
                abort(401, 'Invalid user credentials!');
            }

            //create AT token
            $at = $service->createAT($user, $request->header('x-device-uid'));
            $token = $at->token();
        }

        //get companies
        /** @var FrontendApplication $frontend */
        $frontend = app(FrontendApplication::class);
        $companies = $user->companies($frontend)->get();

        //if multiple companies, return them to the frontend app and let the user choose one.
        if(count($companies) > 1) {
            if($request->hasHeader('x-company-preffered')) {
                $company = $companies->first(function($company) use ($request) {
                    $cf = $request->header('x-company-preffered');
                    if(is_string($cf)) { //name
                        return $company->name == $cf;
                    } elseif(is_int($cf)) { //id
                        return $company->id == $cf;
                    }
                    return false;
                });
            }

            if(isset($company) && $company instanceof Company) {
                return ['at' => $token, 'aat' => $service->createAAT($at, $company)?->token()];
            } else {
                return ['at' => $token, 'companies' => $companies];
            }
        } elseif(count($companies) == 1) {
            return ['at' => $token, 'aat' => $service->createAAT($at, $companies->first())?->token()];
        } else {
            throw new Exception("Geen bedrijven gevonden voor deze gebruiker!");
        }
    }


    /**
     * Get the companies of the logged in user.
     *
     * @param Request $request
     * @return array
     */
    public function companies(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $frontend = app(FrontendApplication::class);
        $companies = $user->companies($frontend)->get();

        return ['companies' => $companies, 'count' => $companies->count()];
    }


    /**
     * Set given company to the logged in user for the frontend application.
     * This generates a new AAT token because permissions changes.
     *
     * The AT token is required for this method.
     *
     * @param Request $request
     * @param TokenService $service
     * @return array
     * @throws Throwable
     */
    public function company(Request $request, TokenService $service)
    {
        //validate the post field
        $company = $request->validate(['company' => 'required|string'])['company'];

        $at = app(AuthenticationToken::class);
        /** @var User $user */
        $user = $request->user();
        $frontend = app(FrontendApplication::class);

        /** @var Company $company */
        $company = $user->companies($frontend)
            ->where('name', '=', $company)
            ->whereHas('users', function(Builder $query) use ($user) {
                $query->where('user_id', '=', $user->id);
            })
            ->firstOrFail();

        return ['aat' => $service->createAAT($at, $company)?->token()];
    }


    /**
     * Logs out the user from everywhere.
     *
     * @param Request $request
     * @param TokenService $service
     * @return bool[]
     */
    public function logout(Request $request, TokenService $service)
    {
        $revoked = $service->revokeTokens($request->user(), $request->user(), 'Logout');
        return ['logged_out' => ($revoked > 0)];
    }


    /**
     * Get an active AT token from given device UID.
     * This AT token can be used to login
     * and obtain an AAT token.
     *
     * @param Request $request
     * @param TokenService $service
     * @return array
     */
    public function tokenFromDeviceUID(Request $request, TokenService $service)
    {
        return ['at' => $service->tokenByDeviceUID($request->header('x-device-uid'))];
    }


}
