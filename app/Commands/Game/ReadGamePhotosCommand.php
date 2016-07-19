<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Game\GamesRepository;

class ReadGamePhotosCommand extends Command implements SelfHandling
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($game_id, $offset, $limit, $orderBy, $orderDirection)
    {
        $this->gameId = $game_id;
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
    public function handle(GamesRepository $gamesRepository)
    {

        $params = [
            'gameId' => $this->gameId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->orderDirection
        ];

        $gamePhotos = $gamesRepository->getGamePhotosWithPagination($params);

        return $gamePhotos;
    }
}
