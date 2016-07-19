<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeagueSeasonGamesRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\LeagueSeasonGame;
use Wooter\LeagueSeasonGameStats;

class CreateLeagueSeasonGameStatsCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $userId;
    
    /*
     * @var
     */
    private $home_team_points;
    
    /*
     * @var
     */
    private $visiting_team_points;
    
    /*
     * @var
     */
    private $league_id;
    
    /*
     * @var
     */
    private $season_id;
    
    /*
     * @var
     */
    private $game_id;


    /**
     * Create a new command instance.
     *
     * @param $userId
     * @param $home_team_points
     * @param $visiting_team_points
     * @param $league_id
     * @param $season_id
     * @param $game_id
     */
    public function __construct($userId, $home_team_points, $visiting_team_points, $league_id, $season_id, $game_id)
    {
        $this->userId = $userId;
        $this->home_team_points  = $home_team_points;
        $this->visiting_team_points = $visiting_team_points;
        $this->league_id = $league_id;
        $this->season_id = $season_id;
        $this->game_id = $game_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository              $userRepository
     * @param LeagueSeasonGamesRepository $gamesRepository
     *
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository,
                           LeagueSeasonGamesRepository $gamesRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
        
        if ($this->home_team_points && $this->visiting_team_points) {
            $stats = new LeagueSeasonGameStats();
            $stats->home_team_points = $this->home_team_points;
            $stats->visiting_team_points = $this->visiting_team_points;
            $stats->game_id = $this->game_id;
            $stats->length = 'overtime';
            $stats->save();
        }
        
        $game = $gamesRepository->getById($this->game_id);
        return $game;
    }
}

