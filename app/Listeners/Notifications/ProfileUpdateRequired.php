<?php

namespace Wooter\Listeners\Notifications;

use Wooter\Events\Notifications\ProfileUpdateRequired as ProfileUpdateRequiredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileUpdateRequired
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
     * @param  ProfileUpdateRequiredEvent  $event
     * @return void
     */
    public function handle(ProfileUpdateRequiredEvent $event)
    {
        //
    }
}
