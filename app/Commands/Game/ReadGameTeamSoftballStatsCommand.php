<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Team\TeamSoftballStatsRepository;

class ReadGameTeamSoftballStatsCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $gameId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($gameId)
    {
        $this->gameId = $gameId;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle(TeamSoftballStatsRepository $teamStatsRepository)
    {
        $stats = $teamStatsRepository->getByGameId($this->gameId);

        return $stats;
    }
}


