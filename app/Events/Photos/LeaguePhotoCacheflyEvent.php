<?php

namespace Wooter\Events\Photos;

use Wooter\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Wooter\LeaguePhoto;
use Wooter\Image;

class LeaguePhotoCacheflyEvent extends Event
{
    use SerializesModels;

    /**
     * @var
     */
    public $leaguePhoto;
    /**
     * @var
     */
    public $image;
    /**
     * @var
     */
    public $organizationId;

    /**
     * Create a new event instance.
     *
     * @param LeaguePhoto $leaguePhoto
     * @param Image       $image
     * @param             $organization_id
     */
    public function __construct(LeaguePhoto $leaguePhoto, Image $image, $organization_id)
    {
        $this->leaguePhoto = $leaguePhoto;
        $this->image = $image;
        $this->organizationId = $organization_id;

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ["broadcast"];
    }
}
