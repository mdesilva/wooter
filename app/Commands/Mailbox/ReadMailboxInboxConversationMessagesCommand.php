<?php

namespace Wooter\Commands\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Mailbox\MailboxConversationMessagesRepository;
use Wooter\Wooter\Repositories\Mailbox\MailboxConversationsRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Route;

class ReadMailboxInboxConversationMessagesCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $userId;
   
    /**
    * @var
    */
    private $parameters;
    
    /*
     * @var 
     */
    private $conversationId;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->parameters = Route::getCurrentRoute()->parameters();
        $this->conversationId = $this->parameters['id'];
        $this->offset = $this->parameters['offset'];
        $this->limit = $this->parameters['limit'];
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
        
        $conversation = $conversationsRepository->getById($this->conversationId);
        
        return $messagesRepository->getFromConversationId($conversation->id, $this->offset, $this->limit);
    }
}
