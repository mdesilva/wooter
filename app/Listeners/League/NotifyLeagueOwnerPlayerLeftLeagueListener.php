<?php

namespace Wooter\Listeners\League;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Notifications\CreateNotificationCommand;
use Wooter\Events\League\NotifyLeagueOwnerPlayerLeftLeagueEvent;
use Wooter\Notification;

class NotifyLeagueOwnerPlayerLeftLeagueListener
{
    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param NotifyLeagueOwnerPlayerLeftLeagueEvent $event
     */
    public function handle(NotifyLeagueOwnerPlayerLeftLeagueEvent $event)
    {
        $data = [
            'user_id' => $event->user_id,
            'title' => $event->player->first_name . ' ' . $event->player->last_name . ' has left ' . $event->league->name . '!',
            'text' => '<a href="/dashboard/leagues/' . $event->league->id . '/players">League Management Players</a>',
            'event_type' => Notification::TYPE_PLAYER_JOIN_LEAGUE
        ];

        $this->dispatchFromArray(CreateNotificationCommand::class, $data);
    }
}
