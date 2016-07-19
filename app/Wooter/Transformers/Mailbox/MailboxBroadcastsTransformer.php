<?php

namespace Wooter\Wooter\Transformers\Mailbox;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\User;

class MailboxBroadcastsTransformer extends Transformer
{
    public function transform($broadcast)
    {
        $user = User::find($broadcast->user_id);
        
        $mail = [
            'id'                 => $broadcast->id,
            'title'              => $broadcast->title,
            'message'            => $broadcast->message,
            'preview'            => $broadcast->preview(),
            'preview_author'     => $user->first_name . ' ' . $user->last_name,
            'preview_author_img' => $user->picture,
            'preview_date'       => $broadcast->date(),
            'preview_datetime'   => $broadcast->datetime()
        ];
        
        return $mail;
    }
}
