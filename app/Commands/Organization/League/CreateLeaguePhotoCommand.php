<?php

namespace Wooter\Commands\Organization\League;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateImageCommand;
use Wooter\LeaguePhoto;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Commands\Organization\League\CreateLeaguePublishPhotosCommand;

class CreateLeaguePhotoCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $photo;
    /**
     * @var
     */
    private $fromCreate;
    /** Vars for league publish photo functions */
    /**
     * @var array
     */
    private $photos = [];

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
    private $leaguePublishPhotoFlag;

    /**
     * CreateLeaguePhotoCommand constructor.
     *
     * @param      $league_id
     * @param      $user_id
     * @param      $photo
     * @param null $description
     * @param bool $fromCreate
     * @param null $photos
     * @param null $players
     * @param null $teams
     * @param bool $leaguePublishPhotoFlag
     */
    public function __construct($league_id,
                                $user_id,
                                $photo = null,
                                $description = null,
                                $fromCreate = false,
                                $photos = null,
                                $players = null,
                                $teams = null,
                                $leaguePublishPhotoFlag = false)
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
        $this->description = $description;
        $this->photo = $photo;
        $this->fromCreate = $fromCreate;
        $this->photos = $photos;
        $this->players = $players;
        $this->teams = $teams;
        $this->leaguePublishPhotoFlag = $leaguePublishPhotoFlag;
    }

    /**
     * Execute the command.
     *
     * @param LeaguePhotoRepository $leaguePhotoRepository
     * @param UserRepository        $userRepository
     * @param LeagueRepository      $leagueRepository
     * @param ImageRepository       $imageRepository
     *
     * @return array|void
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository,
                           UserRepository $userRepository,
                           LeagueRepository $leagueRepository,
                           ImageRepository $imageRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }

        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        if($this->leaguePublishPhotoFlag)
        {
            $this->dispatchFromArray(CreateLeaguePublishPhotosCommand::class, ['photos' => $this->photos,'teams' => $this->teams, 'players' => $this->players, 'user_id' => $this->userId]);

            return true;
        }elseif(is_array($this->photo))
        {
            $photos = array();
            foreach($this->photo as $photo)
            {
                $leaguePhoto = DB::transaction(function () use ($leagueRepository, $leaguePhotoRepository, $imageRepository, $photo) {

                    $image = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $photo, 'league_id' => $this->leagueId, 'description' => $this->description, 'prefix' => LeaguePhoto::IMAGE_PREFIX]);

                    $leaguePhoto = new LeaguePhoto;
                    $leaguePhoto->league_id = $this->leagueId;
                    $leaguePhoto->image_id = $image->id;

                    if (! $leaguePhotoRepository->create($leaguePhoto)) {
                        throw new Exception('League Photo could not be saved');
                    }

                    return $leaguePhoto;
                });

                $photos[] = $leaguePhoto;
            }

            return $photos;
        } else {

            $leaguePhoto = DB::transaction(function () use ($leagueRepository, $leaguePhotoRepository, $imageRepository) {

                $image = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $this->photo, 'league_id' => $this->leagueId, 'description' => $this->description, 'prefix' => LeaguePhoto::IMAGE_PREFIX, 'fromCreate' => $this->fromCreate]);

                $leaguePhoto = new LeaguePhoto;
                $leaguePhoto->league_id = $this->leagueId;
                $leaguePhoto->image_id = $image->id;

                if (! $leaguePhotoRepository->create($leaguePhoto)) {
                    throw new Exception('League Photo could not be saved');
                }

                return $leaguePhoto;
            });

        }


        return $leaguePhoto;
    }
}
