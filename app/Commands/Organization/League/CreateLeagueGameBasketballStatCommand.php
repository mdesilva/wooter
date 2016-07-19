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

class CreateLeagueGameBasketballStatCommand extends Command implements SelfHandling
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
    
    /*
     * @var
     */
    private $game_id;
    
   /**
    * @var
    */
    private $home_team_id;
    
   /**
    * @var
    */
    private $visiting_team_id;


    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $stats
     * @param $league_id
     * @param $game_id
     * @param $home_team_id
     * @param $visiting_team_id
     */
    public function __construct($user_id, $data)
    { 
        $this->user_id = $user_id;
        $this->stats = $data['stats'];
        $this->game_id = $data['gameId'];
        $this->home_team_id = $data['home_team_id'];
        $this->visiting_team_id = $data['visiting_team_id'];
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     * @param PlayerTeamRepository $playerRepository
     * @param TeamRepository $teamRepository
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, 
                           PlayerBasketballStatsRepository $statsRepository,
                           PlayerTeamRepository $playerRepository,
                           TeamRepository $teamRepository)
    {
        $user = $userRepository->getById($this->user_id);
        
        if (!$user) {
            throw new UserNotFound();
        }
        
        $stats_list = [];
        $teams = [
            'home_team_stats',
            'visiting_team_stats'
        ];

        foreach ($teams as $team) {
            $team_id = ($team == 'home_team_stats') ? $this->home_team_id : $this->visiting_team_id;
            $playerTeams = $playerRepository->getAllByTeamId($team_id);
            $players = [];
            foreach($playerTeams as $playerTeam) {
                $players[] = $playerTeam->player;
            }
            $players = collect($players);
            foreach ($this->stats['home_team_stats'] as $stats) {
                $jersey = $stats['jersey'] ? explode('  ', $stats['jersey']) : [null, null];
                $jersey[0] = trim($jersey[0]);
                $jersey[1] = trim($jersey[1]);

                foreach($players as $player){
                    if ($jersey[1] == $player->last_name) {
                        $bballStat = new PlayerBasketballStat();
                
                        $bballStat->team_id = $team_id;
                        $bballStat->game_id = $this->game_id;
                        $bballStat->player_id = $player->id;
                        $bballStat->points = $stats['PTS'];
                        $bballStat->jersey = $stats['jersey'];
                        $bballStat->{'3_points_shots_made'} = $stats['3FG'];
                        $bballStat->{'3_points_shots_attempted'} = $stats['3FGA'];
                        $bballStat->assists = $stats['AST'];
                        $bballStat->blocked_shots = $stats['BLK'];
                        $bballStat->field_goals_made = $stats['FG'];
                        $bballStat->field_goals_attempted = $stats['FGA'];
                        $bballStat->personal_fouls = $stats['FL'];
                        $bballStat->free_throws_made = $stats['FT'];
                        $bballStat->free_throws_attempted = $stats['FTA'];
                        $bballStat->steals = $stats['STL'];
                        $bballStat->turnovers = $stats['TURN'];
                        //$bballStat->offensive_rebounds = $stats['OFFRB'];
                        //$bballStat->defensive_rebounds = $stats['DEFRB'];
                        
                        $statsRepository->create($bballStat);
                        $stats_list[] = $bballStat;
                    }
                }
            }
        }
        return collect($stats_list);
    }
}



