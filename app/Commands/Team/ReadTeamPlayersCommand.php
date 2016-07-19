<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Team\TeamDivisionNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\Team\TeamDivisionRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;

class ReadTeamPlayersCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $teamId;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var string
     */
    private $orderBy;
    /**
     * @var string
     */
    private $orderDirection;
    /**
     * @var int
     */
    private $limit;

    /**
     * @param        $team_id
     * @param        $league_id
     * @param int    $offset
     * @param string $order_by
     * @param string $order_direction
     * @param int    $limit
     *
     * @internal param $competition_type
     * @internal param $competition_id
     */
    public function __construct($team_id, $league_id,
                                $offset = ApiController::DEFAULT_OFFSET,
                                $order_by = ApiController::DEFAULT_ORDER_BY,
                                $order_direction = ApiController::DEFAULT_ORDER_DIRECTION,
                                $limit = ApiController::DEFAULT_LIMIT)
    {
        $this->teamId = $team_id;
        $this->leagueId = $league_id;
        $this->offset = $offset;
        $this->orderBy = $order_by;
        $this->orderDirection = $order_direction;
        $this->limit = $limit;
    }

    public function handle(TeamRepository $teamRepository,
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
        
        if ($league->season_competitions) {
            $firstSeason = $league->season_competitions()->get()->first();

            if ($firstSeason->regular_stages) {
                $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                return $playerTeamRepository
                    ->getPlayersByTeamIdAndStage(
                        $this->teamId,
                        RegularStage::class,
                        $firstRegularStage->id,
                        true,
                        $this->orderBy,
                        $this->orderDirection,
                        $this->offset,
                        $this->limit
                    );
            }
        }

        return [];
    }
}
