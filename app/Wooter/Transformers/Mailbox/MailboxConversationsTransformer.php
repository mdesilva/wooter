<?php

namespace Wooter\Wooter\Transformers\Mailbox;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\User;

class MailboxConversationsTransformer extends Transformer
{
    public function transform($conversation)
    {
        $user = User::find($conversation->messages()->orderBy('id', 'DESC')->first()->user_id);
        
        $mail = [
            'id'                 => $conversation->id,
            'title'              => $conversation->title,
            'preview'            => $conversation->messages()->orderBy('id', 'DESC')->first()->preview(),
            'preview_author_img' => $user->picture,
            'preview_author'     => $user->first_name . ' ' . $user->last_name,
            'preview_date'       => $conversation->messages()->orderBy('id', 'DESC')->first()->date(),
            'preview_datetime'   => $conversation->messages()->orderBy('id', 'DESC')->first()->datetime()
        ];
        
        return $mail;
    }
}

