<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\Player\PlayerFootballQuarterbackStatsRepository;

class ReadGameFootballQuarterbackStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
    * @var
    */
    private $gameId;
    
    /**
    * @var
    */
    private $type;
    
    /**
     * @var
     */
    private $playerId;
    
    /**
     * @var
     */
    private $pick;

    /**
     * Create a new command instance.
     *
     * @param $gameId
     * @param $type
     */
    public function __construct($gameId, $request)
    {
        $this->gameId = $gameId;
        $this->offset = $request['offset'];
        $this->limit = $request['limit'];
        $this->orderBy = $request['orderBy'];
        $this->orderDirection = $request['orderDirection'];
        $this->type = $request['type'];
        $this->playerId = $request['playerId'];
        $this->type = $request['type'];
        $this->pick = $request['pick'];
    }

    /**
     * Execute the command.
     *
     * @param PlayerBasketballStatsRepository $basketballStatsRepository
     *
     * @return array
     * @internal param UserRepository $userRepository
     * @internal param PlayerBasketballStatsRepository $statsRepository
     *
     */
    public function handle(PlayerFootballQuarterbackStatsRepository $quarterbackStatsRepository)
    {
        $params = [
            'offset' => $this->offset,
            'limit' => $this->limit,
            'order_by' => $this->orderBy,
            'order_direction' => $this->orderDirection,
            'game_id' => $this->gameId,
            'type' => $this->type,
            'player_id' => $this->playerId,
            'pick' => $this->pick
        ];
        
        $stats = $quarterbackStatsRepository->search($params);
        
        return $stats;
    }
}


