<?php

namespace App\Http\Controllers;

use App\Models\FrontendApplication;
use App\Services\TokenService;
use Diagro\Token\ApplicationAuthenticationToken;
use Diagro\Token\AuthenticationToken;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Throwable;

class ValidateController extends Controller
{


    /**
     * Validates the diagro token (AAT token)
     *
     * @param Request $request
     * @param TokenService $service
     * @throws Throwable
     */
    public function token(Request $request, TokenService $service)
    {
        $this->validateToken(ApplicationAuthenticationToken::class, $request, $service);
    }


    /**
     * Validates the user token (AT token)
     *
     * @param Request $request
     * @param TokenService $service
     * @throws Throwable
     */
    public function userToken(Request $request, TokenService $service)
    {
        $this->validateToken(AuthenticationToken::class, $request, $service);
    }


    /**
     * Validates a token.
     *
     * @param string $token_class_name
     * @param Request $request
     * @param TokenService $service
     * @throws Throwable
     */
    private function validateToken(string $token_class_name, Request $request, TokenService $service)
    {
        try {
            //is the token valid?
            if(($msg = $service->isValid($request->bearerToken())) !== true) {
                return abort(406, $msg);
            }

            app($token_class_name);
        } catch(ExpiredException $ee)
        {
            return abort(406, 'Expired');
        }
    }


    /**
     * Validates the front application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function app(Request $request)
    {
        //everything is checked in the middleware ValidateAppId
    }


    public function revoke(Request $request, TokenService $service)
    {
        $token = $request->bearerToken();
        $reason = Arr::get($request->all(), 'reason', 'No reason specified!');
        $service->revokeToken($token, $reason);
    }


}
