<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\LeagueGameVenue;
use Wooter\Wooter\Exceptions\GameVenueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Repositories\GameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueGameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class ReadLeagueGameVenuesCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    private $offset;
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
                                $order_by = ApiController::DEFAULT_ORDER_BY, $order_direction = ApiController::DEFAULT_ORDER_DIRECTION)
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
     * @param LeagueRepository          $leagueRepository
     *
     * @return static
     * @throws GameVenueNotFound
     * @throws LeagueNotFound
     */
    public function handle(LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( !$league) {
            throw new LeagueNotFound;
        }

        return LeagueGameVenue::where('league_id', $this->leagueId)
            ->orderBy($this->orderBy, $this->orderDirection)
            ->get()
            ->slice($this->offset, $this->limit);
    }
}
