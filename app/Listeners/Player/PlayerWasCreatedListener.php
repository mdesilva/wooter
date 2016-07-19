<?php

namespace Wooter\Listeners\Player;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Player\NotifyPlayerCreatedCommand;
use Wooter\Events\Player\PlayerWasCreatedEvent;

class PlayerWasCreatedListener
{
    use DispatchesJobs;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  PlayerWasCreatedEvent  $event
     * @return void
     */
    public function handle(PlayerWasCreatedEvent $event)
    {

        $player = $event->player;

        $this->dispatchFromArray(NotifyPlayerCreatedCommand::class, ['player' => $player]);
    }

}
