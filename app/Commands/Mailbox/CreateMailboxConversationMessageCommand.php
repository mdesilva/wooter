<?php

namespace Wooter\Commands\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Mailbox\MailboxConversationMessagesRepository;
use Wooter\Wooter\Repositories\Mailbox\MailboxConversationsRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\MailboxConversation;
use Wooter\MailboxConversationMessage;
use Route;

class CreateMailboxConversationMessageCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $userId;
    
    /*
     * @var
     */
    private $message;
    
    /*
     * @var
     */
    private $conversation_id;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $message, $conversation_id)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->conversation_id = $conversation_id;
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
        
        $message = new MailboxConversationMessage();
      
        $message->user_id = $this->userId;
        $message->message = $this->message;
        
        $conversation = $conversationsRepository->getFromId($this->conversation_id);
        
        $result = $conversation->messages()->save($message);
        
        $conversation->updated_at = $message->updated_at;
        
        $conversation->save();
        
        return $result;
        
    }
}
