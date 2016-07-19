<?php

namespace Wooter\Events\Player;

use Wooter\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Wooter\User;

class PlayerWasCreatedEvent extends Event
{
    use SerializesModels;

    public $player;

    /**
     * Create a new event instance.
     *
     * @param User $player
     */
    public function __construct(User $player)
    {
        $this->player = $player;
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
