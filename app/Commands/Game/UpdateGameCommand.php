<?php

namespace Wooter\Commands\Game;

use Carbon\Carbon;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\GameNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\SportNotFound;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularStageNotFound;
use Wooter\Wooter\Repositories\CompetitionWeeksRepository;
use Wooter\Wooter\Repositories\SportRepository;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Game;

class UpdateGameCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;

    /**
     * @var
     */
    private $homeTeamId;

    /**
     * @var
     */
    private $visitingTeamId;

    /**
     * @var
     */
    private $sportId;

    /**
     * @var
     */
    private $stageId;

    /**
     * @var
     */
    private $stageType;
    /**
     * @var
     */
    private $time;
    /**
     * @var
     */
    private $gameVenueId;
    /**
     * @var
     */
    private $gameId;


    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $game_id
     * @param $home_team_id
     * @param $visiting_team_id
     * @param $game_venue_id
     * @param $sport_id
     * @param $stage_id
     * @param $stage_type
     * @param $time
     */
    public function __construct($user_id,
                                $game_id,
                                $home_team_id,
                                $visiting_team_id,
                                $game_venue_id,
                                $sport_id,
                                $stage_id,
                                $stage_type,
                                $time)
    {
        $this->userId = $user_id;
        $this->homeTeamId = $home_team_id;
        $this->visitingTeamId = $visiting_team_id;
        $this->sportId = $sport_id;
        $this->stageId = $stage_id;
        $this->stageType = $stage_type;
        $this->gameVenueId = $game_venue_id;
        $this->time = $time;
        $this->gameId = $game_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository             $userRepository
     * @param SportRepository            $sportRepository
     * @param CompetitionWeeksRepository $competitionWeeksRepository
     * @param RegularStageRepository     $regularStageRepository
     * @param GamesRepository            $gamesRepository
     *
     * @return bool
     * @throws GameNotFound
     * @throws NotPermissionException
     * @throws RegularStageNotFound
     * @throws SportNotFound
     * @throws UserNotFound
     * @internal param LeagueRepository $leagueRepository
     */
    public function handle(UserRepository $userRepository,
                           SportRepository $sportRepository,
                           CompetitionWeeksRepository $competitionWeeksRepository,
                           RegularStageRepository $regularStageRepository,
                           GamesRepository $gamesRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }

        $stage = $regularStageRepository->getById($this->stageId);

        if (!$stage) {
            throw new RegularStageNotFound;
        }

        if ( ! $user->hasOrganization($stage->competition->organization->id)) {
            throw new NotPermissionException;
        }

        $sport = $sportRepository->getById($this->sportId);

        if (!$sport) {
            throw new SportNotFound;
        }

        $game = $gamesRepository->getById($this->gameId);

        if (!$game) {
            throw new GameNotFound;
        }

        $game->home_team_id = $this->homeTeamId;
        $game->visiting_team_id = $this->visitingTeamId;
        $game->sport_id = $this->sportId;
        $game->stage_id = $this->stageId;
        $game->stage_type = RegularStage::class;
        $game->game_venue_id = $this->gameVenueId;
        $game->time = new Carbon($this->time);
        $game->competition_week_id = $competitionWeeksRepository->getCompetitionWeekId($this->time, $this->stageId, $this->stageType);

        $gamesRepository->create($game);
        
        return $game;
    }
}


