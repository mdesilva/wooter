<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Team\TeamBasketballStatsRepository;

class ReadGameTeamBasketballStatsCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $game_id;

    /**
     * Create a new command instance.
     *
     * @param $game_id
     */
    public function __construct($game_id)
    {
        $this->game_id = $game_id;
    }

    /**
     * Execute the command.
     *
     * @param TeamBasketballStatsRepository $teamStatsRepository
     *
     * @return
     * @internal param UserRepository $userRepository
     * @internal param PlayerBasketballStatsRepository $statsRepository
     *
     */
    public function handle(TeamBasketballStatsRepository $teamStatsRepository)
    {
        $stats = $teamStatsRepository->getByGameId($this->game_id);

        return $stats;
    }
}

