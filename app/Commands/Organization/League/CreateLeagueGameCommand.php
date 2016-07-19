<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Game;

class CreateLeagueGameCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $user_id;
    
    /*
     * @var
     */
    private $home_team_id;
    
    /*
     * @var
     */
    private $visiting_team_id;
    
    /*
     * @var
     */
    private $location_id;
    
    /*
     * @var
     */
    private $game_structure_id;
    
    /*
     * @var
     */
    private $sport_id;
    
    /*
     * @var
     */
    private $home_team_score;
    
    /*
     * @var
     */
    private $visiting_team_score;
    
    /*
     * @var
     */
    private $competition_id;
    
    /*
     * @var
     */
    private $competition_type;
    
    /*
     * @var
     */
    private $stats_id;
    
    /*
     * @var
     */
    private $stats_type;
    
    /*
     * @var
     */
    private $week_id;
    
    /*
     * @var
     */
    private $time;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $home_team_id, $visiting_team_id, $location_id, $game_structure_id, $sport_id, $home_team_score, $visiting_team_score, $competition_id, $competition_type, $stats_id, $stats_type, $week_id, $time)
    {

        $this->user_id = $user_id;
        $this->home_team_id = $home_team_id;
        $this->visiting_team_id = $visiting_team_id;
        $this->location_id = $location_id;
        $this->game_structure_id = $game_structure_id;
        $this->sport_id = $sport_id;
        $this->home_team_score = $home_team_score;
        $this->visiting_team_score = $visiting_team_score;
        $this->competition_id = $competition_id;
        $this->competition_type = $competition_type;
        $this->stats_id = $stats_id;
        $this->stats_type = $stats_type;
        $this->week_id = $week_id;
        $this->time = $time;
        
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository,
                           LeagueRepository $leagueRepository,
                           GamesRepository $gamesRepository)
    {

        $user = $userRepository->getById($this->user_id);

        if (!$user) {
            throw new UserNotFound();
        }
        
        $game = new Game();
        
        $game->home_team_id = $this->home_team_id;
        $game->visiting_team_id = $this->visiting_team_id;
        $game->location_id = $this->location_id;
        $game->game_structure_id = $this->game_structure_id;
        $game->sport_id = $this->sport_id;
        $game->home_team_score = $this->visiting_team_score;
        $game->visiting_team_score = $this->visiting_team_score;
        $game->competition_id = $this->competition_id;
        $game->competition_type = $this->competition_type;
        $game->stats_id = $this->stats_id;
        $game->stats_type = $this->stats_type;
        $game->week_id = $this->week_id;
        $game->time = $this->time;
        
        $success = $gamesRepository->create($game);
        
        return $success ? $game : false;
    }
}
