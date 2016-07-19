<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PlayerTeam;
use Wooter\RegularStage;
use Wooter\TeamDivision;
use Wooter\TeamStage;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;


class DeleteLeagueTeamCommand extends Command implements SelfHandling
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
    public function __construct($league_id,$team_id, $user_id)
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
     * @return bool
     * @throws DatabaseException
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws TeamNotFound
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, TeamRepository $teamRepository, UserRepository $userRepository, PlayerTeamRepository $playerTeamRepository)
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

        DB::transaction(function () use ($league, $team, $playerTeamRepository) {

            if ($league->season_competitions) {
                $firstSeason = $league->season_competitions()->get()->first();

                if ($firstSeason->regular_stages) {
                    $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                    foreach ($firstRegularStage->divisions as $division) {
                        TeamDivision::whereTeamId($team->id)->whereDivisionId($division->id)->delete();
                    }

                    TeamStage::whereStageType(RegularStage::class)->whereTeamId($this->teamId)->whereStageId($firstRegularStage->id)->delete();

                    $players = $playerTeamRepository
                        ->getPlayersByTeamIdAndStage(
                            $this->teamId,
                            RegularStage::class,
                            $firstRegularStage,
                            false
                        );

                    foreach ($players as $player) {
                        PlayerTeam::wherePlayerId($player->id)->whereTeamId($team->id)->whereStageType(RegularStage::class)->whereStageId($firstRegularStage)->delete();
                    }
                }
            }



            $league->teams()->detach($team->id);
        });

        return true;
    }
}
