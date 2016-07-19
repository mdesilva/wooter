<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Route;

class ReadPlayerTeamsCommand extends Command implements SelfHandling
{
    /**
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
     * @param $player_id
     * @param $offset
     * @param $limit
     * @param $order_by
     * @param $order_direction
     */
    public function __construct($player_id, $offset, $limit, $order_by, $order_direction)
    {
        $this->playerId = $player_id;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->orderBy = $order_by;
        $this->orderDirection = $order_direction;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @return mixed
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository)
    {
        $player = $userRepository->getById($this->playerId);

        if ( ! $player) {
            throw new UserNotFound;
        }

        return $player->teams;

    }
}
