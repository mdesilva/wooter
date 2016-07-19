<?php

namespace Wooter\Commands\Wooter\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Mailbox\MailboxConversationMessagesRepository;
use Wooter\Wooter\Repositories\Mailbox\MailboxConversationsRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Route;

class ReadMailboxTrashConversationMessagesCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $userId;
    
    /*
     * @var 
     */
    private $conversation_id;
    
    /*
     * @var
     */
    private $offset;
    
    /*
     * @var
     */
    private $limit;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $conversation_id, $offset, $limit)
    {
        $this->userId = $userId;
        $this->conversation_id = $conversation_id;
        $this->offset = $offset;
        $this->limit = $limit;
    }
    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, 
                           MailboxConversationsRepository $conversationsRepository,
                           MailboxConversationMessagesRepository $messagesRepository)
    {
          
        $user = $userRepository->getById($this->userId);
        
        if (!$user) {
            throw new UserNotFound();
        }
        
        $conversation = $conversationsRepository->getFromId($this->conversation_id);
        
        return $messagesRepository->getFromConversationId($conversation->id, $this->offset, $this->limit);
    }
}
