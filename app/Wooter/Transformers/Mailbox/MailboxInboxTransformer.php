<?php

namespace Wooter\Wooter\Transformers\Mailbox;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\User;

class MailboxInboxTransformer extends Transformer
{
    public function transform($inbox)
    {
       $response =  [
           'id' => $inbox->id
       ];
       
       return $response;
    }
}

