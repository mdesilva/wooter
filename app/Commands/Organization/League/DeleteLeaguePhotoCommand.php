<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteLeaguePhotoCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
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
     */
    public function __construct($league_id, $photo_id, $user_id)
    {

        $this->leagueId = $league_id;
        $this->photoId = $photo_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeaguePhotoRepository $leaguePhotoRepository
     *
     * @param LeagueRepository      $leagueRepository
     * @param ImageRepository       $imageRepository
     * @param UserRepository        $userRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws ImageNotFound
     * @throws LeagueNotBelongToUser
     * @throws LeagueNotFound
     * @throws LeaguePhotoNotFound
     * @throws UserNotFound
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository,
                           LeagueRepository $leagueRepository,
                           ImageRepository $imageRepository,
                           UserRepository $userRepository)
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

        if ( ! $user->hasOrganization($league->id))
        {
            throw new LeagueNotBelongToUser;
        }

        if ( ! $image->delete())
        {
            throw new DatabaseException('There was an error deleting the league photo');
        }

        return true;
    }
}
