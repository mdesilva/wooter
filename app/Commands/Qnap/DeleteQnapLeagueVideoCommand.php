<?php

namespace Wooter\Commands\Qnap;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\VideoRepository;

class DeleteQnapLeagueVideoCommand extends Command implements SelfHandling
{

    private $qnapVideos;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($qnap_videos)
    {
        $this->qnapVideos = $qnap_videos;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository, VideoRepository $videoRepository)
    {
        foreach($this->qnapVideos as $league => $videos)
        {

            foreach($videos as $video)
            {


               $videoModel = $videoRepository->getVideoByHash($video["video_hash"]);


                $leagueVideo = $leagueVideoRepository->getByVideoId($videoModel->id);
                //Detach in records associated with video
                $leagueVideo->team_videos()->detach();
                //Detach in records associated with video
                $leagueVideo->player_videos()->detach();

                $leagueVideo->delete();
                $videoModel->delete();

            }
        }


        return;
    }
}
