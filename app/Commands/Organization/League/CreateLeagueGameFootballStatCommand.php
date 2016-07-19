<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Player\PlayerFootballStatsRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\PlayerFootballStat;

class CreateLeagueGameFootballStatCommand extends Command implements SelfHandling
{
   /**
    * @var
    */
    private $user_id;
    
   /**
    * @var
    */
    private $stats;
    
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
     * @return void
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
     * @return void
     */
    public function handle(UserRepository $userRepository, 
                           PlayerFootballStatsRepository $statsRepository,
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
                        $bballStat = new PlayerFootballStat();
                        
                        $bballStat->league_id = 1;
                        $bballStat->team_id = $team_id;
                        $bballStat->game_id = $this->game_id;
                        $bballStat->player_id = $player->id;
                        $bballStat->jersey = $stats['jersey'];
                        $bballStat->Comp = $stats['Comp'];
                        $bballStat->Att = $stats['Att'];
                        $bballStat->Pct = $stats['Pct'];
                        $bballStat->Yds = $stats['Yds'];
                        $bballStat->YA = $stats['YA'];
                        $bballStat->TD = $stats['TD'];
                        $bballStat->Int = $stats['Int'];
                        $bballStat->Sack = $stats['Sack'];
                        $bballStat->YdsL = $stats['YdsL'];
                        $bballStat->QBRat = $stats['QBRat'];
                        
                        $statsRepository->create($bballStat);
                        $stats_list[] = $bballStat;
                    }
                }
            }
        }
        return collect($stats_list);
    }
}

