<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueVideoNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class ReadLeagueVideosCommand extends Command implements SelfHandling
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
    private $orderByVideosType;

    /**
     * @var
     */
    private $getVideosType;


    /**
     * Create a new command instance.
     *
     * @param $league_id
     */
    public function __construct($league_id, $offset, $limit, $orderBy, $orderDirection, $orderByVideosType, $getVideosType)
    {
        $this->leagueId = $league_id;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->orderBy = $orderBy;
        $this->orderDirection = $orderDirection;
        $this->orderByVideosType = $orderByVideosType;
        $this->getVideosType = $getVideosType;
    }

    /**
     * Execute the command.
     *
     * @param LeagueVideoRepository $leagueVideoRepository
     *
     * @param LeagueRepository      $leagueRepository
     *
     * @return
     * @throws LeagueNotFound
     * @throws LeagueVideoNotFound
     * @throws NotPermissionException
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository, LeagueRepository $leagueRepository)
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
            'orderByVideosType' => $this->orderByVideosType,
            'getVideosType' => $this->getVideosType,

        ];
        $leagueVideos = $leagueVideoRepository->getByLeagueIdWithPagination($params);

        if ( ! $leagueVideos) {
            throw new LeagueVideoNotFound;
        }

        return $leagueVideos;
    }
}