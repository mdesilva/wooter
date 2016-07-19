<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\ImageRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdateLeaguePublishPhotosCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    /**
     * @var
     */
    private $photo;
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
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $photoId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $photo_id
     * @param $user_id
     * @param $photo
     * @param $teams
     * @param $players
     */
    public function __construct($league_id, $photo_id, $user_id, $photo, $teams, $players)
    {
        $this->photo = $photo;
        $this->userId = $user_id;
        $this->teams = $teams;
        $this->players = $players;
        $this->leagueId = $league_id;
        $this->photoId = $photo_id;
    }

    /**
     * Execute the command.
     *
     * @param LeaguePhotoRepository $leaguePhotoRepository
     * @param ImageRepository       $imageRepository
     * @param UserRepository        $userRepository
     * @param LeagueRepository      $leagueRepository
     *
     * @return bool
     * @throws ImageNotFound
     * @throws LeagueNotFound
     * @throws LeaguePhotoNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository, 
                           ImageRepository $imageRepository, 
                           UserRepository $userRepository, 
                           LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);
        
        if ( ! $league) {
            throw new LeagueNotFound;
        }
        
        $photo = $imageRepository->getById($this->photoId);
        
        if ( ! $photo) {
            throw new ImageNotFound;
        }

        $user = $userRepository->getById($this->userId);
        
        if ( ! $user) {
            throw new UserNotFound;
        }
        
        if ( ! $user->hasOrganization($this->leagueId)) {
            throw new NotPermissionException;
        }
        
        $leaguePhoto = $leaguePhotoRepository->getByLeagueIdAndImageId($this->leagueId, $this->photoId);

        if ( ! $leaguePhoto)
        {
            throw new LeaguePhotoNotFound;
        }

        $leaguePhoto = DB::transaction(function () use ($leagueRepository, $leaguePhotoRepository, $imageRepository, $leaguePhoto, $photo, $league) {

            if(isset($this->photo["album_id"]))
            {
                $leaguePhoto->album_id = $this->photo["album_id"];
            }

            if(isset($this->photo["game_id"]))
            {
                $leaguePhoto->game_id = $this->photo["game_id"];
            }

            if(isset($this->photo["division_id"]))
            {
                $leaguePhoto->division_id = $this->photo["division_id"];
            }

            $leaguePhoto->team_photos()->detach();
            if( ! empty($this->teams)){

                foreach($this->teams as $team)
                {
                    $leaguePhoto->team_photos()->attach($team["id"]);
                }
            }

            $leaguePhoto->player_photos()->detach();
            if( ! empty($this->players)){

                foreach($this->players as $player)
                {
                    $leaguePhoto->player_photos()->attach($player["id"]);
                }
            }

            $leaguePhotoRepository->update($leaguePhoto);

            $photo->file_name = $this->photo["file_name"];
            $imageRepository->update($photo);

            return $leaguePhoto;

        });

        return $leaguePhoto->fresh();
    }
}
