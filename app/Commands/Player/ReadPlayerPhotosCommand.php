<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Player\PlayerPhotosRepository;

class ReadPlayerPhotosCommand extends Command implements SelfHandling
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($player_id, $offset, $limit, $orderBy, $orderDirection)
    {
        $this->playerId = $player_id;
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
    public function handle(PlayerPhotosRepository $playerPhotosRepository)
    {
        $params = [
            'playerId' => $this->playerId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->orderDirection
        ];

        $playerPhotos = $playerPhotosRepository->getPlayerPhotosWithPagination($params);

        return $playerPhotos;
    }
}
