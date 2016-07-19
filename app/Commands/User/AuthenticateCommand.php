<?php

namespace Wooter\Commands\User;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Event;
use Wooter\Events\UserWasRegisteredEvent;
use Wooter\Wooter\Exceptions\User\UserDeactivated;

class AuthenticateCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var Request
     */
    private $request;

    /**
     * Create a new command instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the command.
     *
     */
    public function handle()
    {
        $credentials = $this->request->only('email', 'password');
        // TODO: add User Verified checker
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (UserDeactivated $e) {
            // something went wrong
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

}
