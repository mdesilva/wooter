<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\PlayerFootballQuarterbackStatsRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\PlayerFootballQuarterbackStat;

class CreateGameFootballQuarterbackStatsCommand extends Command implements SelfHandling
{
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
    public function __construct($request)
    {
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
    public function handle(PlayerFootballQuarterbackStatsRepository $quarterbackStatsRepository,
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
            
            foreach ($this->stats[$team]['quarterback'] as $stats) {
                foreach ($stats as $key => $stat) {
                    if ($key !== 'name') {
                        $stats[$key] = intval($stat);
                    }
                }
                  
                if ($stats['name']) {
                    $bballStat = new PlayerFootballQuarterbackStat();
                    $bballStat->team_id = $team_id;
                    $bballStat->game_id = $this->gameId;
                    $bballStat->player_id = $stats['player_id'];
                    $bballStat->name = $stats['name'];
                    $bballStat->jersey = $stats['jersey'];
                    $bballStat->active = (($stats['active'] === 1 || $stats['activate'] === 1) && ($stats['deactivate'] === 0)) ? 1 : 0;
                    $bballStat->COMP = $stats['COMP'];
                    $bballStat->ATT = $stats['ATT'];
                    $bballStat->PCT = $this->getPassesCompletedPercentage($stats['COMP'], $stats['ATT']);
                    $bballStat->YDS = $stats['YDS'];
                    $bballStat->AVG = $this->getPassesCompletedAverage($stats['YDS'], $stats['ATT']);
                    $bballStat->TD = $stats['TD'];
                    $bballStat->INT = $stats['INT'];
                    $bballStat->SACKS = $stats['SACKS'];
                    $bballStat->QBR = $this->getQbrating($stats['ATT'], $stats['COMP'], $stats['YDS'], $stats['TD'], $stats['INT']);

                    $quarterbackStatsRepository->create($bballStat);
                    $stats_list[] = $bballStat;
                }
                
            }
        }
        
        return collect($stats_list);
    }
    
    public function getPassesCompletedPercentage($passesCompleted, $passesAttempted) {
        return $passesAttempted ? round(($passesCompleted / $passesAttempted) * 100, 2) : 0;
    }
    
    public function getPassesCompletedAverage($passesCompleted, $passesAttempted) {
        return $passesAttempted ? round($passesCompleted / $passesAttempted, 2) : 0;
    }
    
    public function getQbrating($passesAttempted, $passesCompleted, $yardsGained, $touchdowns, $interceptions) {
        if ($passesAttempted === 0) {
            return 0;
        }
        
        $completionsRating = ($passesCompleted / $passesAttempted) * 100;
        $rule1 = ($completionsRating - 30) * 0.05;
        if ($rule1 > 2.375) {
            $rule1 = 2.375;
        } else if ($rule1 < 0) {
            $rule1 = 0;
        }
        
        $yardsRating = $passesAttempted ? ($yardsGained / $passesAttempted) : 0;
        $rule2 = ($yardsRating - 3) * 0.25;
        if ($rule2 > 2.375) {
            $rule2 = 2.375;
        } else if ($rule2 < 0) {
            $rule2 = 0;
        }
        
        $touchdownsRating = $passesAttempted ? ($touchdowns / $passesAttempted) * 100 : 0;
        $rule3 = $touchdownsRating * 0.2;
        if ($rule3 > 2.375) {
            $rule3 = 2.375;
        }
        
        $interceptionsRating = $passesAttempted ? ($interceptions / $passesAttempted) * 100 : 0;
        $rule4 = 2.375 - ($interceptionsRating * 0.25);
        if ($rule4 < 0) {
            $rule4 = 0;
        }
        
        $rulesTotal = $rule1 + $rule2 + $rule3 + $rule4;
        $QBRating = ($rulesTotal / 6) * 100;
        
        return round($QBRating, 2);
    }
}


