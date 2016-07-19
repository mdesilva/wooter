<?php

namespace Wooter\Commands\Qnap;


use Wooter\LeagueVideo;
use Wooter\Video;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\VideoRepository;


class CreateQnapLeagueVideoCommand extends Command implements SelfHandling
{

    private $qnapVideos = array();

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

                $videoQ = [];

                $videoD = new Video();
                $videoD->file_name = $video["file_name"];
                $videoD->thumbnail_path = $video["thumbnail_path"];
                $videoD->file_path = $video["file_path"];
                $videoD->mime_type = $video["mime_type"];
                $videoD->extension = $video["extension"];
                $videoD->type = Video::QNAP;
                $videoD->video_hash = $video["video_hash"];

                $videoRepository->create($videoD);

                $videoQ["league_id"] = $video["league_id"];
                $videoQ["video_id"] = $videoD->id;


                $leagueVideo = new LeagueVideo($videoQ);

                $leagueVideoRepository->create($leagueVideo);

            }
        }



    }
}
