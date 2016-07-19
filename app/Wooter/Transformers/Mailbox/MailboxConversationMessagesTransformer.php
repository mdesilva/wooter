<?php

namespace Wooter\Wooter\Transformers\Mailbox;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\User;


class MailboxConversationMessagesTransformer extends Transformer
{
    public function transform($message)
    {
        $user = User::find($message->user_id);
        
        $mail = [
            'message'            => $message->message,
            'preview_author'     => $user->first_name . ' ' . $user->last_name,
            'preview_author_img' => $user->picture,
            'author_img'         => $user->picture,
            'preview_date'       => $message->date(),
            'conv_id'            => $message->conversation->id,
            'id'                 => $message->conversation->id,
            'title'              => $message->conversation->title,
            'preview'            => $message->preview(),
            'datetime'           => $message->datetime(),
            'inboxes'            => $message->conversation->inboxes->toArray()
        ];

        return $mail;
    }
}
