<?php

namespace Wooter\Events;

use Wooter\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatRoomCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $userFromId;
    public $userToId;
    public $message;

    public $channel;

    /**
     * Create a new event instance.
     *
     */
    public function __construct($data)
    {
        $this->chhannel = $data['channel'];

        $this->message = $data['message'];
        $this->userFromId = $data['user_from_id'];
        $this->userToId = $data['user_to_id'];
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'test-channel'
        ];
    }
}
