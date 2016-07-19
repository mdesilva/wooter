<?php

namespace Wooter\Commands\User;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Event;
use Wooter\Events\UserWasRegisteredEvent;

class RegisterUserCommand extends Command implements SelfHandling
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
        $user = $this->dispatchFrom(CreateUserCommand::class, $this->request);

        Event::fire(new UserWasRegisteredEvent($user));

        return $user;
    }

}
