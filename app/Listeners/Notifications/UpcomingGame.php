<?php

namespace Wooter\Listeners\Notifications;

use Wooter\Events\Notifications\UpcomingGame as UpcomingGameEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpcomingGame
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
     * @param  UpcomingGameEvent  $event
     * @return void
     */
    public function handle(UpcomingGameEvent $event)
    {
        //
    }
}
