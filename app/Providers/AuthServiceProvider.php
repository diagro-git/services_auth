<?php
namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use App\Services\TokenService;
use Diagro\Token\ApplicationAuthenticationToken;
use Diagro\Token\AuthenticationToken;
use Exception;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //add Diagro AT driver
        Auth::viaRequest('diagro-at', function(Request $request) {
            $token = $request->bearerToken();
            if($token != null) {
                try {
                    //return User App model based on the id of the user in the AT token
                    return User::query()->findOrFail(app()->make(TokenService::class)->createToken(AuthenticationToken::class, $token)?->user()->id());
                } catch(Exception $e) {
                    return null;
                }
            } else {
                return null;
            }
        });
    }
}
