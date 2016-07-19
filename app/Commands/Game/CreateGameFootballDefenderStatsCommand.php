<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\PlayerFootballDefenderStatsRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\PlayerFootballDefenderStat;

class CreateGameFootballDefenderStatsCommand extends Command implements SelfHandling
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
    public function handle(PlayerFootballDefenderStatsRepository $defenderStatsRepository,
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
            foreach ($this->stats[$team]['defender'] as $stats) {
                foreach ($stats as $key => $stat) {
                    if ($key !== 'name') {
                        $stats[$key] = intval($stat);
                    }
                }
                    
                if ($stats['name']) {
                    $bballStat = new PlayerFootballDefenderStat();
                    $bballStat->team_id = $team_id;
                    $bballStat->game_id = $this->gameId;
                    $bballStat->player_id = $stats['player_id'];
                    $bballStat->name = $stats['name'];
                    $bballStat->jersey = $stats['jersey'];
                    $bballStat->active = (($stats['active'] === 1 || $stats['activate'] === 1) && ($stats['deactivate'] === 0)) ? 1 : 0;
                    $bballStat->INT = $stats['INT'];
                    $bballStat->YDS = $stats['YDS'];
                    $bballStat->TKLS = $stats['TKLS'];
                    $bballStat->SACKS = $stats['SACKS'];
                    $bballStat->TD = $stats['TD'];

                    $defenderStatsRepository->create($bballStat);
                    $stats_list[] = $bballStat;
                }
                
            }
        }
        
        return collect($stats_list);
    }
}

