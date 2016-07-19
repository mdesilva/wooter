<?php

namespace Wooter\Commands\User;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\User;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Support\Facades\Auth;

class LoginAsFacebookUserCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $facebookUserId;

    /**
     * Create a new command instance.
     *
     * @param $facebookUserId
     */
    public function __construct($facebookUserId)
    {
        $this->facebookUserId = $facebookUserId;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        //This is default value.
        if ($this->facebookUserId == 0) {
            throw new UserNotFound();
        }

        $user = User::where('facebook_id' ,$this->facebookUserId)->first();

        if ( ! $user) {
            throw new UserNotFound();
        }
        
        return \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
    }
}
