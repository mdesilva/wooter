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

class CreateGameBasketballStatsByUploadCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
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
    private $teamId;
    
    

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($type, $request)
    {
        $this->stats = $request['stats'];
        $this->gameId = $request['gameId'];
        $this->teamId = $request['teamId'];
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle(PlayerBasketballStatsRepository $statsRepository,
                           PlayerTeamRepository $playerRepository)
    {
        $playerTeams = $playerRepository->getAllByTeamId($this->teamId);
        $stats = $this->stats['scoring'];
        $players = [];
        foreach($playerTeams as $playerTeam) {
                $players[] = $playerTeam;
        }
        
        foreach ($stats as $stat) {
            if (isset($stat['Player']) && $stat['Player']) {
                $nameAndJersey = explode('  ', $stat['Player']);
                if (count($nameAndJersey) !== 2) {
                    $nameAndJersey = [null, null];
                }
            } else {
                $nameAndJersey = [null, null];
            }
            
            $jersey = $nameAndJersey[0];
            $name = $nameAndJersey[1];
        
            if (count($players)) {
                foreach ($players as $player) {
                    if ($player->jersey == $jersey) {
                        $playerId = $player->player_id;
                        break;
                    } else {
                        $playerId = 0;
                    }
                }
            } else {
                $playerId = 0;
            }
            
            if ($name) {
                if ($playerId) {
                    $bballStat = PlayerBasketballStat::where('player_id', '=', $playerId)
                                                      ->where('game_id', '=', $this->gameId)
                                                      ->first();
                } else {
                    $bballStat = new PlayerBasketballStat();
                    $bballStat->player_id = $playerId;
                    $bballStat->name = $name;
                    $bballStat->jersey = $jersey;
                }
                
                $bballStat->active = 1;
                $bballStat->team_id = $this->teamId;
                $bballStat->game_id = $this->gameId;
                $bballStat->points = isset($stat['PTS']) ? $stat['PTS'] : 0;
                $bballStat->{'3_points_shots_made'} = isset($stat['3FG']) ? $stat['3FG'] : 0;
                $bballStat->{'3_points_shots_attempted'} = isset($stat['3FGA']) ? $stat['3FGA'] : 0;
                $bballStat->assists = isset($stat['AST']) ? $stat['AST'] : 0;
                $bballStat->blocked_shots = isset($stat['BLK']) ? $stat['BLK'] : 0;
                $bballStat->field_goals_made = isset($stat['FG']) ? $stat['FG'] : 0;
                $bballStat->field_goals_attempted = isset($stat['FGA']) ? $stat['FGA'] : 0;
                $bballStat->personal_fouls = isset($stat['FL']) ? $stat['FL'] : 0;
                $bballStat->free_throws_made = isset($stat['FT']) ? $stat['FT'] : 0;
                $bballStat->free_throws_attempted = isset($stat['FTA']) ? $stat['FTA'] : 0;
                $bballStat->steals = isset($stat['STL']) ? $stat['STL'] : 0;
                $bballStat->turnovers = isset($stat['TURN']) ? $stat['TURN'] : 0;
                $bballStat->offensive_rebounds = isset($stat['OFFRB']) ? $stat['OFFRB'] : 0;
                $bballStat->defensive_rebounds = isset($stat['DEFRB']) ? $stat['DEFRB'] : 0;
                $statsRepository->create($bballStat);
            }
        }
        
        
        return [
            'basketball' => PlayerBasketballStat::where('game_id', '=', $this->gameId)->get()
        ];
    }
}
