<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class ReadLeagueTeamsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    
    /**
     * @var
     */
    private $offset;
    
    /**
     * @var
     */
    private $limit;

    /**
     * @var
     */
    private $orderBy;

    /**
     * @var
     */
    private $orderDirection;
    
    /**
     * @var
     */
    private $divisionId;
    /**
     * @var string
     */
    private $q;
    /**
     * @var bool
     */
    private $all;


    /**
     * Create a new command instance.
     *
     * @param        $league_id
     * @param int    $offset
     * @param int    $limit
     * @param string $order_by
     * @param string $order_direction
     * @param string $q
     * @param bool   $all
     * @param        $division_id
     */
    public function __construct($league_id,
                                $offset = ApiController::DEFAULT_OFFSET,
                                $limit = ApiController::DEFAULT_LIMIT,
                                $order_by = ApiController::DEFAULT_ORDER_BY,
                                $order_direction = ApiController::DEFAULT_ORDER_DIRECTION,
                                $q = '',
                                $all = false,
                                $division_id = null)
    {
        $this->leagueId = $league_id;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->orderBy = $order_by;
        $this->orderDirection = $order_direction;
        $this->divisionId = $division_id;
        $this->q = $q;
        $this->all = $all;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository $leagueRepository
     *
     * @param TeamRepository   $teamRepository
     *
     * @return array
     * @throws LeagueNotFound
     */
    public function handle(LeagueRepository $leagueRepository, TeamRepository $teamRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }
        
        $params = [
            'leagueId' => $this->leagueId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->orderDirection,
            'divisionId' => $this->divisionId,
            'q' => $this->q,
            'all' => $this->all,
        ];
        
        $result = $teamRepository->search($params);
        
        
        return $result;
    }
}

