<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Game\GamesRepository;

class ReadGameVideosCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $gameId;
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

    public function __construct($game_id, $offset, $limit, $orderBy, $orderDirection, $orderByVideosType, $getVideosType)
    {
        $this->gameId = $game_id;
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
    public function handle(GamesRepository $gamesRepository)
    {




        $params = [
            'gameId' => $this->gameId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->orderDirection,
            'orderByVideosType' => $this->orderByVideosType,
            'getVideosType' => $this->getVideosType,

        ];

        $gameVideos = $gamesRepository->getGameVideosWithPagination($params);

        return $gameVideos;
    }
}
