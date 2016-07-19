<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Player\PlayerBasketballStatsRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\PlayerBasketballStat;

class CreateLeagueGameBasketballStatByUploadCommand extends Command implements SelfHandling
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
     * @var
     */
    private $teamId;
    
   /**
    * @var
    */
    private $stats;
    
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $gameId, $teamId, $stats)
    {
        $this->userId = $user_id;
        $this->gameId = $gameId;
        $this->teamId = $teamId;
        $this->stats = $stats;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, 
                           PlayerBasketballStatsRepository $statsRepository,
                           PlayerTeamRepository $playerRepository,
                           TeamRepository $teamRepository)
    {
        $user = $userRepository->getById($this->userId);
        
        if (!$user) {
            throw new UserNotFound();
        }   
        
        
        $team = $teamRepository->getById($this->teamId);
        $playerTeams = $playerRepository->getAllByTeamId($team->id);
        $stats = $this->stats['scoring'];
        $stats_list = [];
        for ($i = 0; $i < count($stats); $i++) {
            $player_id = null;
            if (isset($stats[$i]['Player'])) {
                $jersey = $stats[$i]['Player'] ? explode('  ', $stats[$i]['Player']) : [null, null];
                $jersey_name = $jersey[1] ? $jersey[1] : null;

                foreach ($playerTeams as $playerTeam) {
                    if ($playerTeam->player->last_name == $jersey_name) {
                        $player_id = $playerTeam->player->id;
                    }
                }
            }
            
            if ($player_id) {
                $bballStat = new PlayerBasketballStat();

                $bballStat->team_id = $this->teamId;
                $bballStat->game_id = $this->gameId;
                $bballStat->player_id = $player_id;
                $bballStat->points = $stats[$i]['PTS'];
                $bballStat->jersey = $stats[$i]['Player'];
                $bballStat->{'3_points_shots_made'} = $stats[$i]['3FG'];
                $bballStat->{'3_points_shots_attempted'} = $stats[$i]['3FGA'];
                $bballStat->assists = $stats[$i]['AST'];
                $bballStat->blocked_shots = $stats[$i]['BLK'];
                $bballStat->field_goals_made = $stats[$i]['FG'];
                $bballStat->field_goals_attempted = $stats[$i]['FGA'];
                $bballStat->personal_fouls = $stats[$i]['FL'];
                $bballStat->free_throws_made = $stats[$i]['FT'];
                $bballStat->free_throws_attempted = $stats[$i]['FTA'];
                $bballStat->steals = $stats[$i]['STL'];
                $bballStat->turnovers = $stats[$i]['TURN'];
                /*$bballStat->offensive_rebounds = $stats[$i]['OFFRB'];
                $bballStat->defensive_rebounds = $stats[$i]['DEFRB'];*/
                
                $statsRepository->create($bballStat);
                $stats_list[] = $bballStat;
            }
        }
        
        return collect($stats_list);
    }
}


