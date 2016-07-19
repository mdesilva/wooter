<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerBasketballStatsRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class ReadLeaguePlayerStatCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $user_id;
    
    /*
     * @var
     */
    private $league_id;
    
    /*
     * @var
     */
    private $player_id;
    
    /*
     * @var
     */
    private $season_id;
    
    /*
     * @var
     */
    private $team_id;
    
    /*
     * @var
     */
    private $game_id;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $league_id, $player_id, $season_id, $team_id, $game_id)
    {
        $this->user_id = $user_id;
        $this->league_id = $league_id;
        $this->player_id = $player_id;
        $this->season_id = $season_id;
        $this->team_id = $team_id;
        $this->game_id = $game_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeagueRepository $leagueRepository,
                           PlayerBasketballStatsRepository $statsRepository)
    {
        $league = $leagueRepository->getById($this->league_id);

        if ( ! $league) {
            throw new LeagueNotFound;
        }
        
        $stats = $statsRepository->getByPlayerAndLeagueId($this->player_id, $this->league_id);
        
        $games_played = $stats->count();
        $league_games = 0;
        foreach ($league->seasons as $season) {
            $league_games += $season->games->count();
        }
        
        $percent_played = $games_played / $league_games;
        if ($percent_played > .33) {
            $stats = $this->season_id ? $statsRepository->filterBySeasonId($stats, $this->season_id) : $stats;
            $stats = $this->team_id ? $statsRepository->filterByTeamId($stats, $this->team_id) : $stats;
            $stats = $this->game_id ? $statsRepository->filterByGameId($stats, $this->game_id) : $stats;
        } else {
            $stats = collect([]);
        }
        
        return $stats;
    }
}
