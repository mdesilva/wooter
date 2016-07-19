<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Repositories\Team\TeamBasketballStatsRepository;

class ReadTeamBasketballStatsTotalsCommand extends Command implements SelfHandling
{
    /**
     * @var int
     */
    private $leagueId;
    
    /**
     * @var int
     */
    private $offset;
    /**
     * @var int
     */
    private $limit;
    
    /**
     * @var int
     */
    private $orderBy;
    
    /**
     * @var int
     */
    private $orderDirection;
    
    /**
     * @var int
     */
    private $teamId;
    
    /**
     * @var int
     */
    private $teamId;
    

    /**
     * Create a new command instance.
     *
     * @param bool   $competition_id
     * @param        $competition_type
     * @param string $order_by
     * @param string $order_direction
     * @param int    $offset
     * @param int    $limit
     * @param bool   $season_id
     * @param bool   $division_id
     * @param bool   $week_id
     * @param bool   $player_id
     * @param bool   $team_id
     */
    public function __construct($leagueId, $params)
    {
        $this->leagueId = $leagueId ? $leagueId : false;
        $this->offset = $params['offset'] ? $params['offset'] : ApiController::DEFAULT_OFFSET;
        $this->limit = $params['limit'] ? $params['limit'] : ApiController::DEFAULT_LIMIT;
        $this->orderBy = $params['orderBy'] ? $params['orderBy'] : 'created_at';
        $this->orderDirection = $params['orderDirection'] ? $params['orderDirection'] : ApiController::DEFAULT_ORDER_DIRECTION;
        $this->teamId = $params['teamId'] ? $params['teamId'] : false;
        $this->playerId = $params['playerId'] ? $params['playerId'] : false;
        $this->seasonId = $params['seasonId'] ? $params['seasonId'] : false;
        $this->divisionId = $params['divisionId'] ? $params['seasonId'] : false;
        $this->weekId = $params['weekId'] ? $params['weekId'] : false;
        $this->competitionId = $params['competitionId'] ? $params['competitionId'] : false;
        $this->competitionType = $params['competitionType'] ? $params['competitionType'] : false;
    }

    /**
     * Execute Command
     * @param GamesRepository $gamesRepository
     * @return array
     */
    public function handle(GamesRepository $gamesRepository) {
        $params = [
            'league_id' => $this->leagueId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'order_by' => $this->orderBy,
            'order_direction' => $this->orderDirection,
            'team_id' => $this->teamId,
            'player_id' => $this->playerId,
            'division_id' => $this->divisionId,
            'week_id' => $this->weekId,
            'competition_id' => $this->competitionId,
            'competition_type' => $this->competitionType
        ];
        
        $games = $gamesRepository->search($params);
        
        return $games;
    }
}

