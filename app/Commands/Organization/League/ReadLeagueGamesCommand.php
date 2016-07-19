<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Repositories\Game\GamesRepository;

class ReadLeagueGamesCommand extends Command implements SelfHandling
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
    private $playerId;
    
    /**
     * @var int
     */
    private $seasonId;
    
    /**
     * @var int
     */
    private $divisionId;
    
    /**
     * @var int
     */
    private $weekId;
    
    /**
     * @var int
     */
    private $competitionId;
    
    /**
     * @var int
     */
    private $competitionType;
    
    /**
     * @var
     */
    private $pick;

    /**
     * @var
     */
    private $all;
    
    /**
     * @var
     */
    private $game_status;
    
    /**
     * @var
     */
    private $scored;

    /**
     * Create a new command instance.
     *
     * @param $leagueId
     * @param $request
     *
     * @internal param bool $competition_id
     * @internal param $competition_type
     * @internal param string $order_by
     * @internal param string $order_direction
     * @internal param int $offset
     * @internal param int $limit
     * @internal param bool $season_id
     * @internal param bool $division_id
     * @internal param bool $week_id
     * @internal param bool $player_id
     * @internal param bool $team_id
     */
    public function __construct($leagueId, $request)
    {
        $this->leagueId = $leagueId ? $leagueId : false;
        $this->offset = $request['offset'] ? $request['offset'] : ApiController::DEFAULT_OFFSET;
        $this->limit = $request['limit'] ? $request['limit'] : ApiController::DEFAULT_LIMIT;
        $this->orderBy = $request['orderBy'] ? $request['orderBy'] : ApiController::DEFAULT_ORDER_BY;
        $this->orderDirection = $request['orderDirection'] ? $request['orderDirection'] : ApiController::DEFAULT_ORDER_DIRECTION;
        $this->teamId = $request['teamId'] ? $request['teamId'] : false;
        $this->playerId = $request['playerId'] ? $request['playerId'] : false;
        $this->seasonId = $request['seasonId'] ? $request['seasonId'] : false;
        $this->divisionId = $request['divisionId'] ? $request['seasonId'] : false;
        $this->weekId = $request['weekId'] ? $request['weekId'] : false;
        $this->all = $request['all'] ? $request['all'] : false;
        $this->competitionId = $request['competitionId'] ? $request['competitionId'] : false;
        $this->competitionType = $request['competitionType'] ? $request['competitionType'] : false;
        $this->pick = $request['pick'] || $request['pick'] === '0' ? $request['pick'] : false;
        $this->game_status = $request['game_status'] ? $request['game_status'] : false;
        $this->scored = $request['scored'] ? $request['scored'] : false;
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
            'competition_type' => $this->competitionType,
            'pick' => $this->pick,
            'all' => $this->all,
            'game_status' => $this->game_status,
            'scored' => $this->scored
        ];
        
        $games = $gamesRepository->search($params);
        
        
        
        return $games;
    }
}
