<?php

namespace Wooter\Commands\Competition\Season;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Game;

class CreateSeasonCompetitionGameCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $user_id;
    
    /*
     * @var
     */
    private $season_id;
    
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
    private $competition_week_id;
    
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
    private $stage_id;
    
    /*
     * @var
     */
    private $stage_type;
    
    /*
     * @var
     */
    private $time;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $request /* $season_id, $home_team_id, $visiting_team_id, $location_id, $game_structure_id, $competition_week_id, $sport_id, $home_team_score, $visiting_team_score, $stage_id, $stage_type, $time*/)
    {
        $this->user_id = $user_id;
        $this->season_id = $request['season_id'];
        $this->home_team_id = $request['home_team_id'];
        $this->visiting_team_id = $request['visiting_team_id'];
        $this->location_id = $request['location_id'];
        $this->game_structure_id = $request['game_structure_id'];
        $this->competition_week_id = $request['competition_week_id'];
        $this->sport_id = $request['sport_id'];
        $this->home_team_score = $request['home_team_score'];
        $this->visiting_team_score = $request['visiting_team_score'];
        $this->stage_id = $request['stage_id'];
        $this->stage_type = $request['stage_type'];
        $this->time = $request['time'];
        
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
        $game->competition_week_id = $this->competition_week_id;
        $game->sport_id = $this->sport_id;
        $game->home_team_score = $this->home_team_score;
        $game->visiting_team_score = $this->visiting_team_score;
        $game->stage_id = $this->stage_id;
        $game->stage_type = $this->stage_type;
        $game->time = $this->time;
        
        $success = $gamesRepository->create($game);
        
        return $success ? $game : false;
    }
}

