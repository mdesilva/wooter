<?php

namespace Wooter\Events\Videos;

use Wooter\Events\Event;
use Illuminate\Queue\SerializesModels;


use Wooter\LeagueVideo;
use Wooter\Video;

class LeagueVideoThumbnailAndCachefly extends Event
{
    use SerializesModels;



    /**
     * @var LeagueVideo
     */
    public $leagueVideo;
    /**
     * @var Video
     */
    public $video;
    /**
     * @var
     */
    public $organization_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LeagueVideo $leagueVideo, Video $video, $organizationId)
    {

        $this->leagueVideo = $leagueVideo;
        $this->video = $video;
        $this->organization_id = $organizationId;
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
