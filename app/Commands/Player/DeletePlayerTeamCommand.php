<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerTeamNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\PlayerPositionRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeletePlayerTeamCommand extends Command implements SelfHandling
{
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
    private $competitionType;
    /**
     * @var
     */
    private $competitionId;

    /**
     * @param $player_id
     * @param $team_id
     * @param $user_id
     * @param $competition_type
     * @param $competition_id
     */
    public function __construct($player_id, $team_id, $user_id, $competition_type, $competition_id)
    {
        $this->playerId = $player_id;
        $this->teamId = $team_id;
        $this->userId = $user_id;
        $this->competitionType = $competition_type;
        $this->competitionId = $competition_id;
    }

    /**
     * Execute the command.
     *
     *
     * @param UserRepository       $userRepository
     * @param TeamRepository       $teamRepository
     *
     * @param PlayerTeamRepository $playerTeamRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws PlayerNotFound
     * @throws TeamNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, TeamRepository $teamRepository, PlayerTeamRepository $playerTeamRepository, PlayerPositionRepository $playerPositionRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        switch ($this->competitionType) {
            case LeagueOrganization::class:
            default:

                $league = LeagueOrganization::whereId($this->competitionId)->first();

                if ( ! $league) {
                    throw new LeagueNotFound;
                }

                if ( ! $user->hasOrganization($league->id)) {
                    throw new NotPermissionException;
                }

                break;
        }

        $player = $userRepository->getById($this->playerId);

        if ( ! $player) {
            throw new PlayerNotFound;
        }

        $team = $teamRepository->getById($this->teamId);

        if ( ! $team) {
            throw new TeamNotFound;
        }

        if ($league->season_competitions) {
            $firstSeason = $league->season_competitions()->get()->first();

            if ($firstSeason->regular_stages) {
                $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                $playerTeam = $playerTeamRepository->getPlayerTeamByPlayerIdAndStage($player->id, RegularStage::class, $firstRegularStage->id);

                $playerPosition = $playerPositionRepository->getByPlayerTeamId($playerTeam->id);

                $playerTeam->delete();
                $playerPosition->delete();
            }
        }

        return true;
    }
}
