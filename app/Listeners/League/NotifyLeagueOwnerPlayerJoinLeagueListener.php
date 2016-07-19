<?php

namespace Wooter\Listeners\League;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Notifications\CreateNotificationCommand;
use Wooter\Events\League\NotifyLeagueOwnerPlayerJoinLeagueEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Wooter\Notification;

class NotifyLeagueOwnerPlayerJoinLeagueListener
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
     * @param NotifyLeagueOwnerPlayerJoinLeagueEvent $event
     */
    public function handle(NotifyLeagueOwnerPlayerJoinLeagueEvent $event)
    {
        $data = [
            'user_id' => $event->user_id,
            'title' => $event->player->first_name . ' ' . $event->player->last_name . ' has joined ' . $event->league->name . '!',
            'text' => '<a href="/#/leagues/' . $event->league->id . '/players">League Management Players</a>',
            'event_type' => Notification::TYPE_PLAYER_JOIN_LEAGUE
        ];

        $this->dispatchFromArray(CreateNotificationCommand::class, $data);
    }
}
