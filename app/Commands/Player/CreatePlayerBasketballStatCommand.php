<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Player\PlayerBasketballStatsRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\PlayerBasketballStat;

class CreatePlayerBasketballStatCommand extends Command implements SelfHandling
{
   /**
    * @var
    */
    private $user_id;
    
   /**
    * @var
    */
    private $stats;
    
   /**
    * @var
    */
    private $league_id;
    
   /**
    * @var
    */
    private $team_id;
    
   /**
    * @var
    */
    private $game_id;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $stats, $league_id, $team_id, $game_id)
    {
        $this->user_id = $user_id;
        $this->stats = $stats;
        $this->league_id = $league_id;
        $this->team_id = $team_id;
        $this->game_id = $game_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, 
                           PlayerBasketballStatsRepository $statsRepository)
    {
        $user = $userRepository->getById($this->user_id);
        
        if (!$user) {
            throw new UserNotFound();
        }

        $stats = $this->stats['scoring'];
        $stats_list = [];
        foreach ($stats as $stat) {
            $bballStat = new PlayerBasketballStat();
            
            $bballStat->league_id = $this->league_id;
            $bballStat->team_id = $this->team_id;
            $bballStat->game_id = $this->game_id;
            $bballStat->player_id = 1;
            $bballStat->PTS = $stat['PTS'];
            
            $statsRepository->create($bballStat);
            $stats_list[] = $bballStat;
        }
        
        return collect($stats_list);
    }
}


