<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Team\TeamRepository;

class ReadTeamVideosCommand extends Command implements SelfHandling
{
    /*
    * @var
    */
    private $teamId;
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
     * @return void
     */
    public function __construct($team_id, $offset, $limit, $orderBy, $orderDirection, $orderByVideosType, $getVideosType)
    {
        $this->teamId = $team_id;
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
     * @return void
     */
    public function handle(TeamRepository $teamRepository)
    {
        $params = [
            'teamId' => $this->teamId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->orderDirection,
            'orderByVideosType' => $this->orderByVideosType,
            'getVideosType' => $this->getVideosType,

        ];

        $teamVideos = $teamRepository->getTeamVideosWithPagination($params);

        return $teamVideos;
    }
}
