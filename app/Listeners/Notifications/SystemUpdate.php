<?php

namespace Wooter\Listeners\Notifications;

use Wooter\Events\Notifications\SystemUpdate as SystemUpdateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SystemUpdate
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
     * @param  SystemUpdateEvent  $event
     * @return void
     */
    public function handle(SystemUpdateEvent $event)
    {
        //
    }
}
