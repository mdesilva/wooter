<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\Player\PlayerBasketballStatsRepository;

class ReadLeaguePlayerBasketballStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
        /**
    * @var
    */
    private $type;
    
    /**
     * @var
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
     * @var
     */
    private $competitionId;
    
    /**
     * @var
     */
    private $gameId;
    
    /**
     * @var
     */
    private $teamId;
    
    /**
     * @var
     */
    private $playerId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($type, $leagueId, $request)
    {
        $this->type = $type;
        $this->leagueId = $leagueId;
        $this->offset = $request['offset'] ? $request['offset'] : ApiController::DEFAULT_OFFSET;
        $this->limit = $request['limit'] ? $request['limit'] : ApiController::DEFAULT_LIMIT;
        $this->orderBy = $request['orderBy'] ? $request['orderBy'] : 'created_at';
        $this->orderDirection = $request['orderDirection'] ? $request['orderDirection'] : ApiController::DEFAULT_ORDER_DIRECTION;
        $this->competitionId = $request['competitionId'] ? $request['competitionId'] : false;
        $this->gameId = $request['gameId'] ? $request['gameId'] : false;
        $this->teamId = $request['teamId'] ? $request['teamId'] : false;
        $this->playerId = $request['playerId'] ? $request['playerId'] : false;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle(PlayerBasketballStatsRepository $basketballStatsRepository)
    {
        $params = [
            'organization_type' => '',
            'organization_id' => '',
            'league_id' => $this->leagueId,
            'competition_type' => 'Wooter\SeasonCompetition',
            'competition_id' => $this->competitionId,
            'stage_type' => '',
            'stage_id' => '',
            'game_id' => $this->gameId,
            'team_id' => $this->teamId,
            'player_id' => $this->playerId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'order_by' => $this->orderBy,
            'order_direction' => $this->orderDirection,
            'active' => 1
        ];
        
        $stats = $basketballStatsRepository->searchForAverages($params);
        
        return $stats;
    }
}
