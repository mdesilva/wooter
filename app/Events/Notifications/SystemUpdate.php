<?php

namespace Wooter\Events\Notifications;

use Wooter\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Wooter\Notification;

class SystemUpdate extends Event
{
    use SerializesModels;

    /**
     * @var Notification
     */
    private $notification;

    /**
     * Create a new event instance.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
