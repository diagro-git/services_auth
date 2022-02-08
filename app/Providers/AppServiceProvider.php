<?php

namespace App\Providers;

use App\Models\FrontendApplication;
use App\Services\TokenService;
use Diagro\Token\ApplicationAuthenticationToken;
use Diagro\Token\AuthenticationToken;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TokenService::class, function($app) {
            return new TokenService();
        });

        $this->app->bind(FrontendApplication::class, function() {
            $request = request();
            try {
                $app = FrontendApplication::query()->findOrFail($request->header('X-APP-ID'));
            } catch(ModelNotFoundException $e)
            {
                abort(400, 'Unknown application ID!');
            }

            return $app;
        });

        $this->app->singleton(ApplicationAuthenticationToken::class, function() {
            $token = request()->bearerToken();
            return $this->app->make(TokenService::class)->createToken(ApplicationAuthenticationToken::class, $token);
        });

        $this->app->singleton(AuthenticationToken::class, function() {
            $token = request()->bearerToken();
            return $this->app->make(TokenService::class)->createToken(AuthenticationToken::class, $token);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
