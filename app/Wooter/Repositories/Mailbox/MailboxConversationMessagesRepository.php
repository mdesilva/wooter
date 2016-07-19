<?php

namespace Wooter\Wooter\Repositories\Mailbox;

use DB;
use Wooter\MailboxConversationMessage;

class MailboxConversationMessagesRepository
{

    public function create(MailboxConversationMessage $message)
    {
        return $message->save();
    }

    public function update(MailboxConversationMessage $message)
    {
        return $message->save();
    }

    public function getById($messageId) {
        return MailboxConversationMessage::whereId($messageId)->first();
    }
    
    public function getFromConversationId($conversationId, $offset, $limit)
    {
         return MailboxConversationMessage::whereHas('conversation', function($query) use($conversationId, $offset, $limit){
            $query->where('id', '=', $conversationId);
        })->take($limit)
          ->skip($offset)
          ->orderBy('id', 'DESC')
          ->get();
    }

}

