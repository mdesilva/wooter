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

class CreateLeaguePermissionCommand extends Command implements SelfHandling
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
     * @var
     */
    private $type;
    /**
     * @var
     */
    private $permission;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $user_id
     * @param $type
     * @param $permission
     */
    public function __construct($league_id, $user_id, $type, $permission)
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
        $this->type = $type;
        $this->permission = $permission;
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

        if ( ! in_array($this->type, LeaguePermission::$types)) {
            throw new LeaguePermissionTypeNotFound;
        }

        if ( ! in_array($this->permission, LeaguePermission::$permissionLevels)) {
            throw new LeaguePermissionPermissionLevelFound;
        }

        $leaguePermission = new LeaguePermission;

        $leaguePermission->league_id = $this->leagueId;
        $leaguePermission->type = $this->type;
        $leaguePermission->permission = $this->permission;

        $leaguePermissionRepository->create($leaguePermission);

        return $leaguePermission;

    }
}
