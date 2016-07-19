<?php

namespace Wooter\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\User\AuthenticateCommand;
use Wooter\Commands\User\GetAuthenticatedCommand;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\Wooter\Exceptions\User\UserDeactivated;

final class AuthenticateController extends ApiController
{
    /**
     * @api               {post} api/authenticate POST
     * @apiVersion        1.0.0
     * @apiName           authenticate
     * @apiGroup          Login
     * @apiDescription    Logins a user
     *
     * @apiParam {String} email Email of the user
     * @apiParam {String} password Password of the user
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'token' => JAuth token
     *     }
     *
     * @apiError            invalidCredentials
     * @apiError            UserDeactivated
     * @apiError            JWTException
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function authenticate(Request $request)
    {
        return $this->dispatch(new AuthenticateCommand($request));
    }

    /**
     * @api               {get} api/authenticate GET
     * @apiVersion        1.0.0
     * @apiName           getAuthenticatedUser
     * @apiGroup          Authenticate
     * @apiDescription    Authenticates a user
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'user' => User Object
     *     }
     *
     * @apiError            TokenExpiredException
     * @apiError            UserNotFound
     * @apiError            TokenInvalidException
     * @apiError            JWTException
     *
     * @return JsonResponse
     */
    public function getAuthenticatedUser()
    {
        return $this->dispatch(new GetAuthenticatedCommand());
    }
}
