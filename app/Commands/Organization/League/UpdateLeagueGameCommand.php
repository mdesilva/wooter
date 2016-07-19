<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class UpdateLeagueGameCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $userId;
    
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
    private $league_id;
    
    /*
     * @var
     */
    private $game_id;
    
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $home_team_score, $visiting_team_score, $league_id, $game_id)
    {
        $this->userId = $userId;
        $this->home_team_score  = $home_team_score;
        $this->visiting_team_score = $visiting_team_score;
        $this->league_id = $league_id;
        $this->game_id = $game_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository,
                           GamesRepository $gamesRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
        
        $game = $gamesRepository->getById($this->game_id);
        $game->home_team_score = $this->home_team_score;
        $game->visiting_team_score = $this->visiting_team_score;
        $game->save();
        
        return $game;
    }
}