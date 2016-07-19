<?php

namespace Wooter\Events\League;

use Wooter\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Wooter\LeagueOrganization;
use Wooter\User;

class NotifyLeagueOwnerPlayerJoinLeagueEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var League
     */
    public $league;
    /**
     * @var User
     */
    public $player;
    /**
     * @var User
     */
    public $user_id;

    /**
     * Create a new event instance.
     *
     * @param League $league
     * @param User   $player
     */
    public function __construct(LeagueOrganization $league, User $player)
    {
        $this->league = $league;
        $this->player = $player;

        $this->user_id = $league->user->id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['broadcast'];
    }
}
