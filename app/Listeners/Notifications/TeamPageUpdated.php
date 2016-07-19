<?php

namespace Wooter\Listeners\Notifications;

use Wooter\Events\Notifications\TeamPageUpdated as TeamPageUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TeamPageUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TeamPageUpdatedEvent  $event
     * @return void
     */
    public function handle(TeamPageUpdatedEvent $event)
    {
        //
    }
}
