<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Team\TeamRepository;

class ReadTeamPhotosCommand extends Command implements SelfHandling
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($team_id, $offset, $limit, $orderBy, $orderDirection)
    {
        $this->teamId = $team_id;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->orderBy = $orderBy;
        $this->orderDirection = $orderDirection;

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
            'orderDirection' => $this->orderDirection
        ];

        $teamPhotos = $teamRepository->getTeamPhotosWithPagination($params);

        return $teamPhotos;
    }
}
