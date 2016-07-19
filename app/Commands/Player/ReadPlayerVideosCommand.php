<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Player\PlayerVideosRepository;

class ReadPlayerVideosCommand extends Command implements SelfHandling
{
    /*
    * @var
    */
    private $playerId;
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
    public function __construct($player_id, $offset, $limit, $orderBy, $orderDirection, $orderByVideosType, $getVideosType)
    {
        $this->playerId = $player_id;
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
    public function handle(PlayerVideosRepository $playerVideosRepository)
    {
        $params = [
            'playerId' => $this->playerId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->orderDirection,
            'orderByVideosType' => $this->orderByVideosType,
            'getVideosType' => $this->getVideosType,

        ];

        $playerVideos = $playerVideosRepository->getPlayerVideosWithPagination($params);

        return $playerVideos;
    }
}
