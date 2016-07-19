<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\Player\PlayerBasketballStatsRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\PlayerBasketballStat;

class CreateGameBasketballStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
    * @var
    */
    private $type;
    
    /**
     * @var
     */
    private $stats;
    
    /**
     * @var
     */
    private $gameId;
    
    /**
     * @var
     */
    private $homeTeamId;
    
    /**
     * @var
     */
    private $visitingTeamId;
    
    

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($type, $request)
    {
        $this->type = $type;
        $this->request = $request;
        $this->stats = $request['stats'];
        $this->gameId = $request['gameId'];
        $this->homeTeamId = $request['homeTeamId'];
        $this->visitingTeamId = $request['visitingTeamId'];
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle(PlayerBasketballStatsRepository $basketballStatsRepository,
                           PlayerTeamRepository $playerRepository)
    {
        $stats_list = [];
        $teams = [
            'home_team_stats',
            'visiting_team_stats'
        ];

        foreach ($teams as $team) {
            $team_id = ($team == 'home_team_stats') ? $this->homeTeamId : $this->visitingTeamId;
            $playerTeams = $playerRepository->getAllByTeamId($team_id);
            $players = [];
            foreach($playerTeams as $playerTeam) {
                $players[] = $playerTeam;
            }
            
            foreach ($this->stats[$team]['all'] as $stats) {
                foreach ($stats as $key => $stat) {
                    if ($key !== 'name') {
                        $stats[$key] = intval($stat);
                    }
                }
               
                if ($stats['name']) {
                    $bballStat = new PlayerBasketballStat();
                    $bballStat->team_id = $team_id;
                    $bballStat->game_id = $this->gameId;
                    $bballStat->player_id = $stats['player_id'];
                    $bballStat->points = $stats['PTS'];
                    $bballStat->name = $stats['name'];
                    $bballStat->jersey = $stats['jersey'];
                    $bballStat->active = (($stats['active'] === 1 || $stats['activate'] === 1) && ($stats['deactivate'] === 0)) ? 1 : 0;
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
                    $bballStat->offensive_rebounds = $stats['OFFRB'];
                    $bballStat->defensive_rebounds = $stats['DEFRB'];
                    $basketballStatsRepository->create($bballStat);
                    $stats_list[] = $bballStat;
                }
                
            }
        }
        
        $playerStats = collect($stats_list);
        return [
            'basketball' => $playerStats
        ];
    }
}

