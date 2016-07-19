<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\PlayerSoftballPitcherStatsRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\PlayerSoftballPitcherStat;

class CreateGameSoftballPitcherStatsCommand extends Command implements SelfHandling
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
    public function handle(PlayerSoftballPitcherStatsRepository $pitcherStatsRepository,
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
            
            foreach ($this->stats[$team]['pitcher'] as $stats) {
                foreach ($stats as $key => $stat) {
                    if ($key !== 'name') {
                        $stats[$key] = intval($stat);
                    }
                }
                
                if ($stats['name']) {
                    $bballStat = new PlayerSoftballPitcherStat();
                    $bballStat->team_id = $team_id;
                    $bballStat->game_id = $this->gameId;
                    $bballStat->player_id = $stats['player_id'];
                    $bballStat->name = $stats['name'];
                    $bballStat->jersey = $stats['jersey'];
                    $bballStat->active = (($stats['active'] === 1 || $stats['activate'] === 1) && ($stats['deactivate'] === 0)) ? 1 : 0;
                    $bballStat->IP = $stats['IP'];
                    $bballStat->H = $stats['H'];
                    $bballStat->R = $stats['R'];
                    $bballStat->ERR = $stats['ERR'];
                    $bballStat->BB = $stats['BB'];
                    $bballStat->SO = $stats['SO'];
                    $bballStat->HR = $stats['HR'];
                    $bballStat->PC = $stats['PC'];
                    $bballStat->ST = $stats['ST'];
                    $bballStat->ERA = $this->getEarnedRunAverage($stats['R'], $stats['IP'], $stats['ER']);

                    $pitcherStatsRepository->create($bballStat);
                    $stats_list[] = $bballStat;
                }
                
            }
        }
        
        return collect($stats_list);
    }
    
    public function getEarnedRunAverage($earnedRuns, $inningsPitched, $errors) {
        return $inningsPitched ? round((($earnedRuns - $errors) * 9) / $inningsPitched, 2) : 0;
    }
}

