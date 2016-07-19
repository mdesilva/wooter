<?php

namespace Wooter\Commands\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Mailbox\MailboxInboxRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Route;

class ReadMailboxInboxCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $userId;
    
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, MailboxInboxRepository $inboxRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
        
        return $user->mailbox()
                    ->inbox;

    }
}

