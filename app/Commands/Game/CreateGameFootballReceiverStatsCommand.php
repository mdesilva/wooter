<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\PlayerFootballReceiverStatsRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\PlayerFootballReceiverStat;

class CreateGameFootballReceiverStatsCommand extends Command implements SelfHandling
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
    public function handle(PlayerFootballReceiverStatsRepository $receiverStatsRepository,
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
            
            foreach ($this->stats[$team]['receiver'] as $stats) {
                foreach ($stats as $key => $stat) {
                    if ($key !== 'name') {
                        $stats[$key] = intval($stat);
                    }
                }
                
                if ($stats['name']) {
                    $bballStat = new PlayerFootballReceiverStat();
                    $bballStat->team_id = $team_id;
                    $bballStat->game_id = $this->gameId;
                    $bballStat->player_id = $stats['player_id'];
                    $bballStat->name = $stats['name'];
                    $bballStat->jersey = $stats['jersey'];
                    $bballStat->active = (($stats['active'] === 1 || $stats['activate'] === 1) && ($stats['deactivate'] === 0)) ? 1 : 0;
                    $bballStat->REC = $stats['REC'];
                    $bballStat->YDS = $stats['YDS'];
                    $bballStat->AVG = $this->getPassesReceivedAverage($stats['YDS'], $stats['REC']);
                    $bballStat->TD = $stats['TD'];
                    $bballStat->LONG = $stats['LONG'];
                    $bballStat->TGTS = $stats['TGTS'];
                    $receiverStatsRepository->create($bballStat);
                    $stats_list[] = $bballStat;
                }
            }
        }
        
        return collect($stats_list);
    }
    
    public function getPassesReceivedAverage($passesReceived, $targets) {
        return $targets ? round($passesReceived / $targets, 2) : 0;
    }
}
