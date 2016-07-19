<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Competition\Season\SeasonCompetitionNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Competition\Season\SeasonCompetitionsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueSeasonRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteLeagueSeasonCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueSeasonId;
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
    private $seasonId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $user_id
     * @param $season_id
     *
     * @internal param $league_season_id
     */
    public function __construct($league_id, $user_id, $season_id)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->seasonId = $season_id;
    }

    /**
     * Execute the command.
     *
     * @param SeasonCompetitionsRepository $seasonCompetitionsRepository
     * @param LeagueRepository             $leagueRepository
     *
     * @param UserRepository               $userRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws LeagueNotBelongToUser
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws SeasonCompetitionNotFound
     * @throws UserNotFound
     * @internal param LeagueSeasonRepository $leagueSeasonRepository
     */
    public function handle(SeasonCompetitionsRepository $seasonCompetitionsRepository, LeagueRepository $leagueRepository,  UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $season = $seasonCompetitionsRepository->getById($this->seasonId);

        if ( ! $season)
        {
            throw new SeasonCompetitionNotFound;
        }

        if ($season->organization->id != $league->id) {
            throw new NotPermissionException;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        if ( ! $season->delete())
        {
            throw new DatabaseException('There was an error deleting the league season');
        }

        return true;
    }
}
