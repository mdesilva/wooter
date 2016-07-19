<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\GameNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class DeleteGameCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    
    /**
     * @var
     */
    private $gameId;


    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $game_id
     */
    public function __construct($user_id, $game_id)
    {
        $this->userId = $user_id;
        $this->gameId = $game_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository  $userRepository
     * @param GamesRepository $gamesRepository
     *
     * @return bool
     * @throws GameNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository,
                           GamesRepository $gamesRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        $game = $gamesRepository->getById($this->gameId);

        if (!$game) {
            throw new GameNotFound;
        }

        $gamesRepository->deleteById($this->gameId);

        return true;
    }
}


