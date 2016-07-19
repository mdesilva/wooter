<?php

namespace Wooter\Commands\Team;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateImageCommand;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\SeasonCompetition;
use Wooter\Team;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateTeamPlayersCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $players;
    /**
     * @var
     */
    private $teamId;
    /**
     * @var
     */
    private $leagueId;

    /**
     * Create a new command instance.
     *
     * @param $team_id
     * @param $players
     * @param $user_id
     * @param $league_id
     */
    public function __construct($team_id, $players, $user_id, $league_id)
    {
        $this->userId = $user_id;
        $this->players = $players;
        $this->teamId = $team_id;
        $this->leagueId = $league_id;
    }


    /**
     * @param TeamRepository       $teamRepository
     *
     * @param UserRepository       $userRepository
     *
     * @param LeagueRepository     $leagueRepository
     *
     * @param PlayerTeamRepository $playerTeamRepository
     *
     * @return bool
     * @throws LeagueNotFound
     * @throws PlayerNotFound
     * @throws TeamNotFound
     * @throws UserNotFound
     */
    public function handle(TeamRepository $teamRepository,
                           UserRepository $userRepository,
                           LeagueRepository $leagueRepository,
                           PlayerTeamRepository $playerTeamRepository)
    {
        $team = $teamRepository->getById($this->teamId);

        if ( ! $team) {
            throw new TeamNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        foreach ($this->players as $playerId) {

            $player = $userRepository->getById($playerId);

            if ( ! $player) {
                throw new PlayerNotFound;
            }

            if ($league->season_competitions) {
                $firstSeason = $league->season_competitions()->get()->first();

                if ($firstSeason->regular_stages) {
                    $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                    $playerTeamRepository->deleteByPlayerIdAndStage($playerId, RegularStage::class, $firstRegularStage->id);
                    $playerTeamRepository->addTeamIdByPlayerIdAndStage($this->teamId, $playerId, RegularStage::class, $firstRegularStage->id);
                }
            }
        }

        return true;
    }

}
