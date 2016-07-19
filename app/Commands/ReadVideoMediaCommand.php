<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Exceptions\VideoNotFound;

class ReadVideoMediaCommand extends Command implements SelfHandling
{
    private $videoId;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($video_id)
    {
        $this->videoId = $video_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository)
    {
        $video = $leagueVideoRepository->getById($this->videoId);

        if (!$video) {
            throw new VideoNotFound;
        }

        return $video;
    }
}
