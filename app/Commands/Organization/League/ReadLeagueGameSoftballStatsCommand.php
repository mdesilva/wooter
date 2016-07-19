<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Player\PlayerSoftballStatsRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class ReadLeagueGameSoftballStatsCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $user_id;
    
        /**
    * @var
    */
    private $game_id;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $game_id)
    {
        $this->user_id = $user_id;
        $this->game_id = $game_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, 
                           PlayerSoftballStatsRepository $statsRepository)
    {
        $user = $userRepository->getById($this->user_id);
        
        if (!$user) {
            throw new UserNotFound();
        }
        
        $stats = $statsRepository->getByGameId($this->game_id);
        return $stats;
    }
}
