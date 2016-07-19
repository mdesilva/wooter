<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\ImageRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Event;
use Wooter\Events\Photos\LeaguePhotoCacheflyEvent;

class CreateLeaguePublishPhotosCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    /**
     * @var array
     */
    private $photos = [];

    /**
     * @var
     */
    private $userId;

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
     * @param $user_id
     * @param $photos
     * @param $teams
     * @param $players
     */
    public function __construct($user_id, $photos, $teams, $players)
    {
        $this->photos = $photos;
        $this->userId = $user_id;
        $this->teams = $teams;
        $this->players = $players;
    }

    /**
     * Execute the command.
     *
     * @param LeaguePhotoRepository $leaguePhotoRepository
     * @param ImageRepository       $imageRepository
     * @param LeagueRepository      $leagueRepository
     *
     * @return bool
     * @throws LeagueNotBelongToUser
     * @throws LeaguePhotoNotFound
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository, ImageRepository $imageRepository, LeagueRepository $leagueRepository)
    {
        $index = 0;
        foreach($this->photos as $photoParam)
        {

            $leaguePhoto = $leaguePhotoRepository->getById($photoParam["photoId"]);

            if ( ! $leaguePhoto)
            {
                throw new LeaguePhotoNotFound;
            }

            DB::transaction(function () use ($leagueRepository, $leaguePhotoRepository, $imageRepository, $leaguePhoto, $index, $photoParam) {


                $league = $leagueRepository->getById($leaguePhoto->league_id);

                if ($leaguePhoto->league->user->id !== $this->userId) {
                    throw new LeagueNotBelongToUser;
                }

                if(isset($photoParam["album_id"]))
                {
                    $leaguePhoto->album_id = $photoParam["album_id"];
                }

                if(isset($photoParam["game_id"]))
                {
                    $leaguePhoto->game_id = $photoParam["game_id"];
                }

                if(isset($photoParam["division_id"]))
                {
                    $leaguePhoto->division_id = $photoParam["division_id"];
                }

                $leaguePhotoRepository->update($leaguePhoto);


                $leaguePhoto->team_photos()->detach();
                if(!empty($this->teams[$index])){
                    foreach($this->teams[$index] as $team)
                    {
                        $leaguePhoto->team_photos()->attach($team["id"]);
                    }
                }

                $leaguePhoto->player_photos()->detach();
                if(!empty($this->players[$index])){
                    foreach($this->players[$index] as $player)
                    {
                        $leaguePhoto->player_photos()->attach($player["id"]);
                    }
                }

                $image = $imageRepository->getById($leaguePhoto->image_id);
                $image->file_name = $photoParam["photoName"];

                $imageRepository->update($image);

                if( !isset( $photoParam["action"] ) ){
                    Event::fire(new LeaguePhotoCacheflyEvent($leaguePhoto, $image, $league->user->id));
                }
            });

            $index++;
        }

        return true;
    }
}
