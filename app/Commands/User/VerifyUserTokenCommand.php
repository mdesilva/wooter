<?php

namespace Wooter\Commands\User;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Events\SuccessfulRegistration;
use Wooter\User;
use Wooter\Wooter\Contracts\Auth\VerifyUserBroker;
use Wooter\Wooter\Facades\VerifyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class VerifyUserTokenCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $token;

    /**
     * Create a new command instance.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Execute the command.
     *
     */
    public function handle()
    {
        $response = VerifyUser::verify($this->token, function (User $user) {
            $this->verifyUser($user);
        });

        switch ($response) {
            case VerifyUserBroker::USER_VERIFIED:
                return 200;

            case VerifyUserBroker::INVALID_TOKEN:
                return 422;

            default:
                return null;
        }
    }

    /**
     * @param User $user
     */
    private function verifyUser(User $user)
    {
        $user->verified = 1;

        $user->save();

        Event::fire(new SuccessfulRegistration($user));
    }
}
