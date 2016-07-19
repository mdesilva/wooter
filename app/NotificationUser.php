<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    /**
     * The notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    /**
     * The user that the notification belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
