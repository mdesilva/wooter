<?php

namespace Wooter\Commands\Organization\League;

use Carbon\Carbon;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\SearchStats;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class SearchLeaguesCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $zip;
    /**
     * @var
     */
    private $minAge;
    /**
     * @var
     */
    private $maxAge;
    /**
     * @var
     */
    private $longitude;
    /**
     * @var
     */
    private $latitude;
    /**
     * @var
     */
    private $distance;
    /**
     * @var
     */
    private $sport;
    /**
     * @var
     */
    private $limit;
    /**
     * @var null
     */
    private $gender;
    /**
     * @var
     */
    private $userId;
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
     * @var bool
     */
    private $own;
    /**
     * @var bool
     */
    private $archived;

    /**
     * Create a new command instance.
     *
     * @param          $user_id
     * @param          $name
     * @param          $zip
     * @param          $min_age
     * @param bool     $own
     * @param          $max_age
     * @param          $longitude
     * @param          $latitude
     * @param          $distance
     * @param          $sport
     * @param int|null $limit
     * @param null     $gender
     * @param int      $offset
     * @param string   $order_by
     * @param string   $order_direction
     */
    public function __construct($user_id, $name = null, $zip = null, $min_age = null, $own = false, $archived = null,
                                $max_age = null, $longitude = null, $latitude = null,
                                $distance = null, $sport = null, $limit = ApiController::DEFAULT_LIMIT,
                                $gender = null, $offset = ApiController::DEFAULT_OFFSET,
                                $order_by = ApiController::DEFAULT_ORDER_BY,
                                $order_direction = ApiController::DEFAULT_ORDER_DIRECTION)
    {
        $this->name = $name;
        $this->zip = $zip;
        $this->minAge = $min_age;
        $this->maxAge = $max_age;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->distance = $distance;
        $this->sport = $sport;
        $this->limit = $limit;
        $this->gender = $gender;
        $this->userId = $user_id;
        $this->offset = $offset;

        if ($order_direction === 'asc' || $order_direction === 'desc' ||
                $order_direction === 'ASC' || $order_direction === 'DESC') {
            $this->orderDirection = $order_direction;
        } else {
            $this->orderDirection = ApiController::DEFAULT_ORDER_DIRECTION;
        }

        $this->orderBy = $order_by;
        $this->own = $own;
        $this->archived = $archived;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository $leagueRepository
     */
    public function handle(LeagueRepository $leagueRepository)
    {
        $params = [
            'user_id' => $this->userId,
            'name' => $this->name,
            'zip' => $this->zip,
            'min_age' => $this->minAge,
            'max_age' => $this->maxAge,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'sport' => $this->sport,
            'own' => $this->own,
            'archived' => $this->archived,
            'limit' => $this->limit,
            'distance' => $this->distance,
            'gender' => $this->gender,
            'offset' => $this->offset,
            'order_by' => $this->orderBy,
            'order_direction' => $this->orderDirection,
        ];

        $saveSearch = new SearchStats();
        $saveSearch->params = json_encode($params);
        $saveSearch->save();

        return $leagueRepository->search($params);

    }
}
