<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\Role;
use Wooter\SeasonCompetition;
use Wooter\UserRole;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Competition\Season\SeasonCompetitionsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CheckUserIsLeagueOwnerCommand extends Command implements SelfHandling
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
     * Create a new command instance.
     *
     * @param      $league_id
     * @param      $user_id
     */
    public function __construct($league_id, $user_id)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
    }

    /**
     * Tries to create a league and save it in DB
     *
     * @param LeagueRepository $leagueRepository
     * @param UserRepository   $userRepository
     *
     * @return bool
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);
        
        if ( ! $user)
        {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        return true;
    }
}
