<?php

namespace Wooter\Commands\Qnap;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\VideoRepository;

class UpdateQnapLeagueVideoCommand extends Command implements SelfHandling
{
    /**
     * @var array
     */
    private $qnapVideos = array();

    /**
     * @var string
     */
    private $teams;

    /**
     * @var
     */
    private $players;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($qnap_videos, $teams = "", $players = "")
    {
        $this->qnapVideos = $qnap_videos;
        $this->teams = $teams;
        $this->players = $players;
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

                foreach($video as $column => $value)
                {
                    if($column != "youtube_src" && $column != "league_id")
                    {
                        $videoModel->$column = $value;
                    }
                    elseif($videoModel->$column == "" && $column != "league_id")
                    {
                        $videoModel->$column = $value;
                    }
                }


                $leagueVideo = $leagueVideoRepository->getByVideoId($videoModel->id);

                /*$videoModel->file_name = $video["file_name"];
                $videoModel->src = $video["src"];

                if
                $videoModel->file_name = $video["file_name"];
                $videoModel->src = $video["src"];*/


                /**
                 * Associate video with teams if any team is being tagged
                 *
                 */

                if(!empty($this->teams)){

                    //Detach in records associated with video
                    $leagueVideo->team_videos()->detach();

                    foreach($this->teams as $team)
                    {
                        //Attach team with video
                        $leagueVideo->team_videos()->attach($team["id"]);
                    }


                }else{

                    //If no teams tags than remove all team associations with that video
                    $leagueVideo->team_videos()->detach();

                }

                /**
                 * Associate video with teams if any team is being tagged
                 *
                 */

                if(!empty($this->players)){

                    //Detach in records associated with video
                    $leagueVideo->player_videos()->detach();

                    foreach($this->players as $player)
                    {
                        //Attach player with video
                        $leagueVideo->player_videos()->attach($player["id"]);
                    }


                }else{

                    //If no player tags than remove all player associations with that video
                    $leagueVideo->player_videos()->detach();

                }


                $videoRepository->create($videoModel);
            }
        }
    }
}
