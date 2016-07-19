<?php

namespace Wooter\Listeners\Notifications;

use Wooter\Events\Notifications\MatchScoreUpdated as MatchScoreUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MatchScoreUpdated
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
     * @param  MatchScoreUpdatedEvent  $event
     * @return void
     */
    public function handle(MatchScoreUpdatedEvent $event)
    {
        //
    }
}
