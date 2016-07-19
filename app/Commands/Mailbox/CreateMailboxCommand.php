<?php

namespace Wooter\Commands\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Mailbox\MailboxInboxRepository;
use Wooter\Wooter\Repositories\Mailbox\MailboxTrashRepository;
use Wooter\Mailbox;
use Wooter\MailboxInbox;
use Wooter\MailboxTrash;

class CreateMailboxCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $userId;
    
    /*
     * @var
     */
    private $userType;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $userType)
    {
        $this->userId = $userId;
        $this->userType = $userType;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(MailboxInboxRepository $inboxRepository, MailboxTrashRepository $trashRepository)
    {
        
        $mailbox = new Mailbox();
        $mailbox->owner_id = $this->userId;
        $mailbox->owner_type = 'WooterUser';
        $mailbox->save();
 
        $inbox = new MailboxInbox();
        $inbox->mailbox_id = $mailbox->id;
        $inboxRepository->create($inbox);
        
        $trash = new MailboxTrash();
        $trash->mailbox_id = $mailbox->id;
        $trashRepository->create($trash);
        
        
    }
}
