<?php

namespace Wooter\Commands\User;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteUserCommand extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

       if ( !$user->delete()) {
            throw new DatabaseException('There was an error when deleting the user');
        }

        return true;
    }
}
