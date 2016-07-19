<?php

namespace Wooter\Commands\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Mailbox\MailboxBroadcastsRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Route;

class ReadMailboxInboxBroadcastCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $userId;
   
    /**
    * @var
    */
    private $id;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $id)
    {
        $this->userId = $userId;
        $this->id = $id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, MailboxBroadcastsRepository $broadcastsRepository)
    {
        $user = $userRepository->getById($this->userId);
        
        if (!$user) {
            throw new UserNotFound();
        }
        
        return $broadcastsRepository->getById($this->id);
        
    }
}

