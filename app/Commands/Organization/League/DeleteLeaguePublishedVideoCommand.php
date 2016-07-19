<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\VideoRepository;
use Wooter\Wooter\Exceptions\Organization\League\LeagueVideoNotFound;
use Illuminate\Contracts\Bus\SelfHandling;

class DeleteLeaguePublishedVideoCommand extends Command implements SelfHandling
{


    /**
     * @var array
     */
    private $videos = array();

    /**
     * @var
     */
    private $user_id;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $videos)
    {
        $this->videos = $videos;
        $this->user_id = $user_id;
    }


    /**
     * @param LeagueVideoRepository $leagueVideoRepository
     * @param VideoRepository $videoRepository
     * @throws LeagueVideoNotFound
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository, VideoRepository $videoRepository)
    {

        foreach($this->videos as $videoParam)
        {

            $leagueVideo = $leagueVideoRepository->getById($videoParam["videoId"]);

            if ( ! $leagueVideo)
            {
                throw new LeagueVideoNotFound;
            }

            $video = $videoRepository->getById($leagueVideo->video_id);

            if(file_exists($video->file_path))
            {
                unlink($video->file_path);
            }



            //Detach in records associated with video
            $leagueVideo->team_videos()->detach();
            //Detach in records associated with video
            $leagueVideo->player_videos()->detach();


            $leagueVideo->delete();
            $video->delete();



        }

        return;

    }
}
