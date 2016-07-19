<?php

namespace Wooter\Commands\Organization\League;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateImageCommand;
use Wooter\LeaguePhoto;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\ImageTooBigException;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Commands\Organization\League\UpdateLeaguePublishPhotosCommand;

class UpdateLeaguePhotoCommand extends Command implements SelfHandling
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
    private $fromCreate;
    /**
     * @var array
     */
    private $photos = array();

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
     * @var
     */
    private $photoId;

    /**
     * CreateLeaguePhotoCommand constructor.
     *
     * @param      $leagueId
     * @param      $userId
     * @param      $photoId
     * @param null $description
     * @param bool $fromCreate
     * @param null $photos
     * @param null $players
     * @param null $teams
     * @param bool $leaguePublishPhotoFlag
     */
    public function __construct($leagueId,
                                $userId,
                                $photoId,
                                $description = null,
                                $fromCreate = false,
                                $photos = null,
                                $players = null,
                                $teams = null,
                                $leaguePublishPhotoFlag = false)
    {
        $this->leagueId = $leagueId;
        $this->userId = $userId;
        $this->description = $description;
        $this->fromCreate = $fromCreate;
        $this->photos = $photos;
        $this->players = $players;
        $this->teams = $teams;
        $this->leaguePublishPhotoFlag = $leaguePublishPhotoFlag;
        $this->photoId = $photoId;
    }

    /**
     * Execute the command.
     *
     * @param LeaguePhotoRepository $leaguePhotoRepository
     * @param UserRepository        $userRepository
     * @param LeagueRepository      $leagueRepository
     * @param ImageRepository       $imageRepository
     *
     * @return array
     * @throws ImageNotFound
     * @throws LeagueNotFound
     * @throws LeaguePhotoNotFound
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
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $image = $imageRepository->getById($this->photoId);

        if ( ! $image) {
            throw new ImageNotFound;
        }

        $leaguePhoto = $leaguePhotoRepository->getByLeagueIdAndImageId($this->leagueId, $this->photoId);

        if ( ! $leaguePhoto) {
            throw new LeaguePhotoNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $leaguePhoto->league_id = $this->leagueId;
        $leaguePhoto->image_id = $image->id;

        return $leaguePhoto;
    }
}
