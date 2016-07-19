<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\Player\PlayerBasketballStatsRepository;

class DeleteGameBasketballStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
    * @var
    */
    private $gameId;
    
        /**
    * @var
    */
    private $type;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($gameId, $type)
    {
        $this->gameId = $gameId;
        $this->type = $type;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle(PlayerBasketballStatsRepository $basketballStatsRepository)
    {
        $success = $basketballStatsRepository->deleteByGameId($this->gameId);
        
        return $success;
    }
}


