<?php

namespace Wooter\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Wooter\Commands\User\Facebook\FacebookRegisterLoginCommand;
use Wooter\Commands\User\Facebook\FacebookIntegrationCommand;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Wooter\Wooter\Traits\Responder;

class FacebookController extends Controller
{
    use Responder;

    public function __construct(Socialite $socialite){
        $this->socialite = $socialite;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return $this->socialite->driver('facebook')->scopes([
                        'public_profile',
                        'user_friends',
                        'user_birthday',
                        'user_about_me',
                        'email'
                    ])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            //$this->dispatch(new FacebookIntegrationCommand);
            $user = $this->dispatch(new FacebookRegisterLoginCommand);

            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            // if no errors are encountered we can return a JWT
            return response()->json(compact('token', 'user'));

        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
