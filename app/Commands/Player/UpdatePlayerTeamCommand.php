<?php

namespace Wooter\Commands\Player;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\PlayerTeam;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdatePlayerTeamCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $teamId;
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
    private $jersey;

    /**
     * Create a new command instance.
     *
     * @param $player_id
     * @param $team_id
     * @param $user_id
     * @param $league_id
     * @param $jersey
     */
    public function __construct($player_id, $team_id, $user_id, $league_id, $jersey)
    {
        $this->playerId = $player_id;
        $this->teamId = $team_id;
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->jersey = $jersey;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository       $userRepository
     * @param LeagueRepository     $leagueRepository
     * @param TeamRepository       $teamRepository
     *
     * @param PlayerTeamRepository $playerTeamRepository
     *
     * @return PlayerTeam
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws PlayerNotFound
     * @throws TeamNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository,
                           LeagueRepository $leagueRepository,
                           TeamRepository $teamRepository,
                           PlayerTeamRepository $playerTeamRepository)
    {
        $player = $userRepository->getById($this->playerId);

        if (! $player) {
            throw new PlayerNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user)
        {
            throw new UserNotFound;
        }

        $team = $teamRepository->getById($this->teamId);

        if ( ! $team)
        {
            throw new TeamNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        if ( ! $player) {
            throw new PlayerNotFound;
        }

        if ($league->season_competitions) {
            $firstSeason = $league->season_competitions()->get()->first();

            if ($firstSeason->regular_stages) {
                $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                $playerTeam = $playerTeamRepository->getPlayerTeamByPlayerIdAndStage($player->id, RegularStage::class, $firstRegularStage->id);

                if ($playerTeam) {
                    $playerTeam->jersey = $this->jersey;

                    $playerTeamRepository->update($playerTeam);

                    return $playerTeam->fresh()->player;
                }
            }
        }

        throw new PlayerNotFound;
    }
}
