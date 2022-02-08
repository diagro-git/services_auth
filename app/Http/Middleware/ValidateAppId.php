<?php
namespace App\Http\Middleware;

use App\Models\FrontendApplication;
use Closure;
use Illuminate\Http\Request;

/**
 * Checks if the X-APP-ID header is precense.
 * Validates the application id.
 *
 * @package Diagro\Backend\Middleware
 */
class ValidateAppId
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
        abort_unless($request->hasHeader('X-APP-ID'), 400, 'Missing header X-APP-ID');

        abort_unless(FrontendApplication::query()->where('id', '=', $request->header('X-APP-ID'))->exists(), 400, 'Application does not exists!');

        return $next($request);
    }


}
