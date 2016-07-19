<?php

namespace Wooter\Commands\User;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\User;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;
use Route;


class ReadUserCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $userId;
    
    /*
     * @var
     */
    private $id;
   
    
    public function __construct($userId, $id)
    {
        $this->userId = $userId;
        $this->id = $id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @return string
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
        
        return $userRepository->getById($this->id);
    }
}
