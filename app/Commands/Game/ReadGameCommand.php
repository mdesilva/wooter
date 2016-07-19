<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\GameNotFound;
use Wooter\Wooter\Exceptions\GameVenueNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Game;
use Wooter\TeamBasketballStat;

class ReadGameCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $gameId;

    /**
     * Create a new command instance.
     *
     * @param $game_id
     */
    public function __construct($game_id)
    {

        $this->gameId = $game_id;
    }

    /**
     * Execute the command.
     *
     * @param GamesRepository $gamesRepository
     *
     * @throws GameNotFound
     */
    public function handle(GamesRepository $gamesRepository)
    {
        $game = $gamesRepository->getById($this->gameId);

        if ( ! $game) {
            throw new GameNotFound;
        }

        return $game;
    }
}

