<?php

namespace Wooter\Wooter\Transformers\Notification;

use Wooter\Wooter\Transformers\Transformer;

class NotificationTransformer extends Transformer
{
    public function transform($notification)
    {
        return [
            'id' => $notification->id,
            'title' => $notification->title,
            'text' => $notification->text,
            'image' => $notification->image,
            'user' => $notification->user,
            'user_id' => $notification->user_id,
            'event_type' => $notification->event_type,
            'consumed' => $notification->consumed,
        ];
    }
}