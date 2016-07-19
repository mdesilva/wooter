<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\VideoRepository;
use Wooter\Wooter\Exceptions\Organization\League\LeagueVideoNotFound;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Events\Videos\LeagueVideoThumbnailAndCachefly;
use Illuminate\Support\Facades\Event;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class UpdateLeaguePublishVideosCommand extends Command implements SelfHandling
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
    * @var
    */
    private $players;

    /**
     * @var
     */
    private $teams;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $videos, $teams, $players)
    {
        $this->videos = $videos;
        $this->user_id = $user_id;
        $this->teams = $teams;
        $this->players = $players;
    }

    /**
     * @param LeagueVideoRepository $leagueVideoRepository
     * @param VideoRepository $videoRepository
     * @throws LeagueVideoNotFound
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository, VideoRepository $videoRepository, LeagueRepository $leagueRepository)
    {

        $index = 0;
        foreach($this->videos as $videoParam)
        {

           $leagueVideo = $leagueVideoRepository->getById($videoParam["videoId"]);



            if ( ! $leagueVideo)
            {
                throw new LeagueVideoNotFound;
            }


            $league = $leagueRepository->getById($leagueVideo->league_id);



            if(isset($videoParam["videoCategory"]))
            {
                $leagueVideo->label_id = $videoParam["videoCategory"];

            }

            if( isset($videoParam["videoGame"]) )
            {
                $leagueVideo->game_id = $videoParam["videoGame"];
            }



            $leagueVideoRepository->update($leagueVideo);



            //Check if request is from edit model
            if( isset( $videoParam["action"] ) &&  $videoParam["action"] == 'edit' )
            {

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
                 * Associate video with players if any player is being tagged
                 *
                 */
                if(!empty($this->players)){

                    //Detach in records associated with video
                    $leagueVideo->player_videos()->detach();

                    foreach($this->players as $player)
                    {
                        //Attach Player with video
                        $leagueVideo->player_videos()->attach($player["id"]);
                    }


                }else{

                    //If no teams tags than remove all team associations with that video
                    $leagueVideo->player_videos()->detach();

                }

            }else{

                /**
                 * Associate video with teams if any team is being tagged
                 *
                 */
                if(!empty($this->teams[$index])){


                    //Detach in records associated with video
                    $leagueVideo->team_videos()->detach();

                    foreach($this->teams[$index] as $team)
                    {
                        //Attach team with video
                        $leagueVideo->team_videos()->attach($team["id"]);
                    }


                }else{

                    //If no teams tags than remove all team associations with that video
                    $leagueVideo->team_videos()->detach();

                }



                /**
                 * Associate video with players if any player is being tagged
                 *
                 */
                if(!empty($this->players[$index])){

                    //Detach in records associated with video
                    $leagueVideo->player_videos()->detach();

                    foreach($this->players[$index] as $player)
                    {
                        //Attach Player with video
                        $leagueVideo->player_videos()->attach($player["id"]);
                    }


                }else{

                    //If no teams tags than remove all team associations with that video
                    $leagueVideo->player_videos()->detach();

                }


            }


            $video = $videoRepository->getById($leagueVideo->video_id);

            if(isset($videoParam["youTubeUrl"]) && $videoParam["youTubeUrl"] != "")
            {
                $this->youtube_id_from_url($videoParam["youTubeUrl"]);

                $youTube_Id = $this->youtube_id_from_url($videoParam["youTubeUrl"]);

                if(!$youTube_Id){
                    $video->youtube_src = "";
                }else{
                    $video->youtube_src = $youTube_Id;
                }

            }else{

                $video->youtube_src = "";
            }
            $video->file_name = $videoParam["videoName"];

            $videoRepository->update($video);

            $index++;

            if( !isset( $videoParam["action"] ) ){

                Event::fire(new LeagueVideoThumbnailAndCachefly($leagueVideo, $video, $league->user->id));

            }


        }

        return;

    }


    /**
     * get youtube video ID from URL
     *
     * @param string $url
     * @return string Youtube video id or FALSE if none found.
     */
    private function youtube_id_from_url($url) {

       $result =  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);

        if($result){
            return $match[1];
        }
        return false;
    }
}
