<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\RegularStage;
use Wooter\TeamStage;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\Team\TeamAlreadyJoinedLeague;

use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamLeaguesRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;

use Wooter\TeamLeague;
use Wooter\Wooter\Repositories\User\UserRepository;


class CreateLeagueTeamCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $teamId;
    /**
     * @var
     */
    private $userId;

    /**
     * @param $league_id
     * @param $team_id
     * @param $user_id
     */
    public function __construct($league_id, $team_id, $user_id)
    {
        $this->leagueId = $league_id;
        $this->teamId = $team_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository $leagueRepository
     * @param TeamRepository   $teamRepository
     *
     * @param UserRepository   $userRepository
     *
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws TeamNotFound
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, TeamRepository $teamRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $team = $teamRepository->getById($this->teamId);

        if ( ! $team) {
            throw new TeamNotFound;
        }

        if ($league->season_competitions) {
            $firstSeason = $league->season_competitions()->get()->first();

            if ($firstSeason->regular_stages) {
                $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                $teamStage = new TeamStage;
                $teamStage->stage_id = $firstRegularStage->id;
                $teamStage->stage_type = RegularStage::class;
                $teamStage->team_id = $this->teamId;
                $teamStage->save();
            }
        }

        $league->teams()->attach($team->id);
    }
}
