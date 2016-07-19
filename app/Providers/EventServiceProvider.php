<?php

namespace Wooter\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Wooter\Events\UserWasRegisteredEvent' => [
            'Wooter\Listeners\EmailUserRegisteredListener',
        ],
        'Wooter\Events\Player\PlayerWasCreatedEvent' => [
            'Wooter\Listeners\Player\PlayerWasCreatedListener',
        ],
        'Wooter\Events\Player\PlayerWasAddedToLeagueEvent' => [
            'Wooter\Listeners\Player\PlayerWasAddedToLeagueListener',
        ],
        'Wooter\Events\Player\PlayerWasAddedToTeamEvent' => [
            'Wooter\Listeners\Player\PlayerWasAddedToTeamListener',
        ],
        'Wooter\Events\League\NotifyLeagueOwnerPlayerJoinLeagueEvent' => [
            'Wooter\Listeners\League\NotifyLeagueOwnerPlayerJoinLeagueListener',
        ],
        'Wooter\Events\League\NotifyLeagueOwnerPlayerLeftLeagueEvent' => [
            'Wooter\Listeners\League\NotifyLeagueOwnerPlayerLeftLeagueListener',
        ],
        'Wooter\Events\SuccessfulRegistration' => [
            'Wooter\Listeners\EmailSuccessfulRegistration',
        ],
        'Wooter\Events\Notifications\MatchScoreUpdated' => [
            'Wooter\Listeners\Notifications\MatchScoreUpdated',
        ],
        'Wooter\Events\Notifications\TeamPageUpdated' => [
            'Wooter\Listeners\Notifications\TeamPageUpdated',
        ],
        'Wooter\Events\Notifications\UpcomingGame' => [
            'Wooter\Listeners\Notifications\UpcomingGame',
        ],
        'Wooter\Events\Notifications\SystemUpdate' => [
            'Wooter\Listeners\Notifications\SystemUpdate',
        ],
        'Wooter\Events\Notifications\ProfileUpdateRequired' => [
            'Wooter\Listeners\Notifications\ProfileUpdateRequired',
        ],
        'Wooter\Events\Email\StaticFormSubmissionEvent'=>[
            'Wooter\Listeners\Email\StaticFormSubmissionListener',
        ],
        'Wooter\Events\Videos\LeagueVideoThumbnailAndCachefly'=>[
            'Wooter\Listeners\Videos\LeagueVideoThumbnailAndCacheflyListener',
        ],
         'Wooter\Events\Photos\LeaguePhotoCacheflyEvent'=>[
            'Wooter\Listeners\Photos\LeaguePhotoCacheflyListener',
        ],

    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
