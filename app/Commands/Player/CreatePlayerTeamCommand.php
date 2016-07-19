<?php

namespace Wooter\Commands\Player;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\PlayerPosition;
use Wooter\PlayerTeam;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerPositionRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Commands\Player\NotifyPlayerAddedToTeamCommand;

class CreatePlayerTeamCommand extends Command implements SelfHandling
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
     * Create a new command instance.
     *
     * @param $player_id
     * @param $team_id
     * @param $user_id
     * @param $league_id
     */
    public function __construct($player_id, $team_id, $user_id, $league_id)
    {
        $this->playerId = $player_id;
        $this->teamId = $team_id;
        $this->userId = $user_id;
        $this->leagueId = $league_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository           $userRepository
     * @param LeagueRepository         $leagueRepository
     * @param TeamRepository           $teamRepository
     *
     * @param PlayerPositionRepository $playerPositionRepository
     * @param PlayerTeamRepository     $playerTeamRepository
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
                           PlayerPositionRepository $playerPositionRepository,
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

        DB::transaction(function () use ($league, $player, $team, $playerPositionRepository, $playerTeamRepository) {
            if ($league->season_competitions) {
                $firstSeason = $league->season_competitions()->get()->first();

                if ($firstSeason->regular_stages) {
                    $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                    $playerTeam = $playerTeamRepository->addTeamIdByPlayerIdAndStage($this->teamId, $player->id, RegularStage::class, $firstRegularStage->id);
                    
                    $playerPosition = $playerPositionRepository->getByPlayerTeamId($playerTeam->id);

                    if ( ! $playerPosition) {
                        $playerPosition = new PlayerPosition();
                        $playerPosition->player_team_id = $playerTeam->id;
                    }
                    $playerPosition->position_id = 1; // todo set to whatever position it is in the once we have UI for it

                    $playerPositionRepository->update($playerPosition);
                }
            }
            
            //$this->dispatchFromArray(NotifyPlayerAddedToTeamCommand::class, compact('player', 'team'));

        });
        

        return $team;
    }
}
