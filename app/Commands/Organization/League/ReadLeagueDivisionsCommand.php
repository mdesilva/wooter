<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueDivisionsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class ReadLeagueDivisionsCommand extends Command implements SelfHandling
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
     *
     * @param string $order_by
     * @param string $order_direction
     *
     * @internal param $league_id
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
     * @param LeagueRepository $leagueRepository
     *
     * @return array
     * @throws LeagueNotFound
     */
    public function handle(LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if ($league->season_competitions) {
            $firstSeason = $league->season_competitions()->get()->first();

            if ($firstSeason->regular_stages) {
                $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                return $firstRegularStage->divisions()
                    ->orderBy($this->orderBy, $this->orderDirection)
                    ->get()
                    ->slice($this->offset, $this->limit);
            }
        }

        return [];
    }
}
