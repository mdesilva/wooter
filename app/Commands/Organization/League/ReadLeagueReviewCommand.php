<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueReviewRepository;

class ReadLeagueReviewCommand extends Command implements SelfHandling
{
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
     * @var string
     */
    private $orderBy;
    /**
     * @var string
     */
    private $orderDirection;

    /**
     * Create a new command instance.
     *
     * @param        $league_id
     * @param int    $offset
     * @param int    $limit
     * @param string $order_by
     * @param string $order_direction
     */
    public function __construct($league_id, $offset = ApiController::DEFAULT_OFFSET,
                                $limit = ApiController::DEFAULT_LIMIT,
                                $order_by = ApiController::DEFAULT_ORDER_BY,
                                $order_direction = ApiController::DEFAULT_ORDER_DIRECTION)
    {
        $this->leagueId = $league_id;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->orderBy = $order_by;
        $this->orderDirection = $order_direction;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository       $leagueRepository
     * @param LeagueReviewRepository $leagueReviewRepository
     *
     * @return
     * @throws LeagueNotFound
     */
    public function handle(LeagueRepository $leagueRepository, LeagueReviewRepository $leagueReviewRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        return $leagueReviewRepository->getByLeagueIdAndFilters($this->leagueId, $this->offset, $this->limit, $this->orderBy, $this->orderDirection);
    }
}
