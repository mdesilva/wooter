<?php

namespace Wooter\Commands\User;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Exception;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class UpdateUserCommand extends Command implements SelfHandling
{
    private $userId;
    private $status;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($status , $user_id,$first_name = null,$last_name=null,$phone=null,$email=null)
    {
        $this->userId = $user_id;
        $this->status = $status;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone = $phone;
        $this->email = $email;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }

        $user->active = $this->status;

        //Update User information
        if (!empty($this->first_name)) {
            $user->first_name = $this->first_name;
        }

        if (!empty($this->last_name)) {
            $user->last_name = $this->last_name;
        }

        if (!empty($this->phone)) {
            $user->phone = $this->phone;
        }

        if (!empty($this->email)) {
            $user->email = $this->email;
        }

        $userRepository->update($user);

        return $user;
    }
}
