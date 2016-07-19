<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Repositories\Team\TeamSoftballStatsRepository;

class ReadLeagueTeamSoftballStatsCommand extends Command implements SelfHandling
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
    private $seasonId;
    
    /**
     * @var int
     */
    private $stageId;
    
    /**
     * @var int
     */
    private $gameId;
    

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
        $this->orderBy = $params['order_by'] ? $params['order_by'] : 'created_at';
        $this->orderDirection = $params['order_direction'] ? $params['order_direction'] : ApiController::DEFAULT_ORDER_DIRECTION;
        $this->teamId = $params['team_id'] ? $params['team_id'] : false;
        $this->seasonId = $params['season_id'] ? $params['season_id'] : false;
        $this->stageId = $params['stage_id'] ? $params['stage_id'] : false;
        $this->gameId = $params['game_id'] ? $params['game_id'] : false;
    }

    /**
     * Execute Command
     * @param GamesRepository $gamesRepository
     * @return array
     */
    public function handle(TeamSoftballStatsRepository $teamStatsRepository) {
        $params = [
            'leagueId' => $this->leagueId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->orderDirection,
            'teamId' => $this->teamId,
            'seasonId' => $this->seasonId,
            'stageId' => $this->stageId,
            'gameId' => $this->gameId
        ];
        
        $stats = $teamStatsRepository->search($params);
        return $stats;
    }
}

