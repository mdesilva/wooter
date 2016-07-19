<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeletePlayerCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerId;

    /**
     * Create a new command instance.
     *
     * @param $player_id
     */
    public function __construct($player_id)
    {
        $this->playerId = $player_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $playerRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws NotPermissionException
     * @throws PlayerNotFound
     */
    public function handle(UserRepository $playerRepository)
    {
        $player = $playerRepository->getById($this->playerId);

        if ( ! $player) {
            throw new PlayerNotFound;
        }

        if ( ! $player->delete()) {
            throw new DatabaseException('There was an error deleting the record');
        }

        return true;
    }
}
