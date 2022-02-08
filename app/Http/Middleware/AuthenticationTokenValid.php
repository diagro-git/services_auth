<?php

namespace App\Http\Middleware;

use App\Services\TokenService;
use Closure;
use Illuminate\Http\Request;

class AuthenticationTokenValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //is the token valid?
        $service = app(TokenService::class);
        if(($msg = $service->isValid($request->bearerToken())) !== true) {
            return abort(406, $msg);
        }

        return $next($request);
    }
}
