<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class ReadLeaguePhotosCommand extends Command implements SelfHandling
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
     * Create a new command instance.
     *
     * @param $league_id
     * @param $offset
     * @param $limit
     * @param $orderBy
     * @param $orderDirection
     */
    public function __construct($league_id, $offset, $limit, $orderBy, $orderDirection) {
        $this->leagueId = $league_id;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->orderBy = $orderBy;
        $this->orderDirection = $orderDirection;
    }

    /**
     * Execute the command.
     *
     * @param LeaguePhotoRepository $leaguePhotoRepository
     *
     * @param LeagueRepository      $leagueRepository
     *
     * @return array
     * @throws LeagueNotFound
     * @throws LeaguePhotoNotFound
     */
    public function handle (LeaguePhotoRepository $leaguePhotoRepository, LeagueRepository $leagueRepository) {
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
         ];

        $leaguePhotos = $leaguePhotoRepository->getByLeagueIdWithPagination($params);

        if ( !$leaguePhotos ) {
            throw new LeaguePhotoNotFound;
        }

        return $leaguePhotos;
    }
}