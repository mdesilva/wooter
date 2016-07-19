<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\PlayerSoftballBatterStatsRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\PlayerSoftballBatterStat;

class CreateGameSoftballBatterStatsCommand extends Command implements SelfHandling
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
    public function handle(PlayerSoftballBatterStatsRepository $batterStatsRepository,
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
            
            foreach ($this->stats[$team]['batter'] as $stats) {
                foreach ($stats as $key => $stat) {
                    if ($key !== 'name') {
                        $stats[$key] = intval($stat);
                    }
                }
                
                if ($stats['name']) {
                    $bballStat = new PlayerSoftballBatterStat();
                    $bballStat->team_id = $team_id;
                    $bballStat->game_id = $this->gameId;
                    $bballStat->player_id = $stats['player_id'];
                    $bballStat->name = $stats['name'];
                    $bballStat->jersey = $stats['jersey'];
                    $bballStat->active = (($stats['active'] === 1 || $stats['activate'] === 1) && ($stats['deactivate'] === 0)) ? 1 : 0;
                    $bballStat->AB = $stats['AB'];
                    $bballStat->R = $stats['R'];
                    $bballStat->H = $stats['H'];
                    $bballStat->RBI = $stats['RBI'];
                    $bballStat->SO = $stats['SO'];
                    $bballStat->HBP = $stats['HBP'];
                    $bballStat->SF = $stats['SF'];
                    $bballStat->TB = $stats['TB'];
                    $bballStat->AVG = $this->getBattingAverage($stats['H'], $stats['AB']);
                    $bballStat->OBP = $this->getOnBasePercentage($stats['H'], $stats['BB'], $stats['HBP'], $stats['AB'], $stats['SF']);
                    $bballStat->SLG = $this->getSluggingAverage($stats['TB'], $stats['AB']);
                    $batterStatsRepository->create($bballStat);
                    $stats_list[] = $bballStat;
                }
              
            }
        }
        
        return collect($stats_list);
    }
    
    public function getBattingAverage($hits, $atBats) {
        return $atBats ? round($hits / $atBats, 2) : 0;
    }
    
    public function getOnBasePercentage($hits, $walks, $hitsByPitch, $atBats, $sacrificeFlies) {
        if (($atBats + $walks + $hitsByPitch + $sacrificeFlies)) {
            $onBasePercentage = round(($hits + $walks + $hitsByPitch) / ($atBats + $walks + $hitsByPitch + $sacrificeFlies) * 100, 2);
        } else {
            $onBasePercentage = 0;
        }
        
        return $onBasePercentage;
    }
    
    public function getSluggingAverage($totalBases, $atBats) {
        return $atBats ? round($totalBases / $atBats, 2) : 0;
    }
}
