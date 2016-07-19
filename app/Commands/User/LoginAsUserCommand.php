<?php

namespace Wooter\Commands\User;
use JWTAuth;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\User;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Support\Facades\Auth;

class LoginAsUserCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the command.
     *
     * @throws UserNotFound
     */
    public function handle()
    {
        $user = User::whereId($this->userId)->first();

        if ( ! $user) {
            throw new UserNotFound();
        }
        
        return \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
    }
}
