<?php

namespace Wooter\Commands\User;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Event;
use Wooter\Events\UserWasRegisteredEvent;
use Wooter\Wooter\Exceptions\User\UserDeactivated;

class GetAuthenticatedCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * Execute the command.
     *
     */
    public function handle()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        $user['organization'] = $user->isOrganization();
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

}
