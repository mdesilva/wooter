<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;

class ReadPlayerCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $player_id
     * @param $user_id
     */
    public function __construct($player_id, $user_id)
    {
        $this->playerId = $player_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $playerRepository
     *
     * @return \Wooter\User
     * @throws PlayerNotFound
     */
    public function handle(UserRepository $playerRepository)
    {
        $player = $playerRepository->getById($this->playerId);

        if ( ! $player) {
            throw new PlayerNotFound;
        }

        return $player;
    }
}
