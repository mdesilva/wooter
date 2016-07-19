<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;

class ReadLeaguePhotoCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leaguePhotoId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $league_photo_id
     * @param $user_id
     */
    public function __construct($league_photo_id, $user_id)
    {
        $this->leaguePhotoId = $league_photo_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeaguePhotoRepository $leaguePhotoRepository
     *
     * @return
     * @throws LeaguePhotoNotFound
     * @throws NotPermissionException
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository)
    {
        $leaguePhoto = $leaguePhotoRepository->getById($this->leaguePhotoId);

        if ( ! $leaguePhoto) {
            throw new LeaguePhotoNotFound;
        }

        if ($leaguePhoto->league->user->id !== $this->userId) {
            throw new NotPermissionException;
        }

        return $leaguePhoto;
    }
}
