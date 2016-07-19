<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeaguePermission;
use Wooter\LeaguePrice;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePermissionPermissionLevelFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePermissionTypeNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeaguePermissionRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePriceRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class ReadLeaguePermissionsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $user_id
     */
    public function __construct($league_id, $user_id)
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository           $leagueRepository
     * @param LeaguePermissionRepository $leaguePermissionRepository
     * @param UserRepository             $userRepository
     *
     * @return LeaguePermission
     * @throws LeagueNotFound
     * @throws LeaguePermissionPermissionLevelFound
     * @throws LeaguePermissionTypeNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository,
                           LeaguePermissionRepository $leaguePermissionRepository,
                           UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user)
        {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        return $leaguePermissionRepository->getByLeagueId($this->leagueId);

    }
}
