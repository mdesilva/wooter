<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueDetailsNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueDetailsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class UpdateLeagueDetailsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $timePeriod;
    /**
     * @var
     */
    private $gameDuration;
    /**
     * @var
     */
    private $maxPlayers;
    /**
     * @var
     */
    private $gamesPerTeam;
    /**
     * @var
     */
    private $playersPerTeam;
    /**
     * @var
     */
    private $numberOfTeams;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     * @param $league_id
     * @param $description
     * @param $number_of_teams
     * @param $players_per_team
     * @param $games_per_team
     * @param $max_players
     * @param $game_duration
     * @param $time_period
     * @param $user_id
     */
    public function __construct($user_id, $league_id,
                                $description,
                                $number_of_teams,
                                $players_per_team,
                                $games_per_team,
                                $game_duration,
                                $max_players = null,
                                $time_period = null)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->timePeriod = $time_period;
        $this->gameDuration = $game_duration;
        $this->maxPlayers = $max_players;
        $this->gamesPerTeam = $games_per_team;
        $this->playersPerTeam = $players_per_team;
        $this->numberOfTeams = $number_of_teams;
        $this->description = $description;
    }

    /**
     * Tries to create a league and save it in DB
     *
     * @param LeagueRepository        $leagueRepository
     * @param LeagueDetailsRepository $leagueDetailsRepository
     *
     * @return bool
     * @throws LeagueNotBelongToUser
     * @throws LeagueNotFound
     */
    public function handle(LeagueRepository $leagueRepository, LeagueDetailsRepository $leagueDetailsRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $leagueDetails = $league->details;

        $leagueDetails->time_period = $this->timePeriod;
        $leagueDetails->game_duration = $this->gameDuration;
        $leagueDetails->max_players = $this->maxPlayers;
        $leagueDetails->games_per_team = $this->gamesPerTeam;
        $leagueDetails->players_per_team = $this->playersPerTeam;
        $leagueDetails->number_of_teams = $this->numberOfTeams;
        $leagueDetails->description = $this->description;

        $leagueDetailsRepository->update($leagueDetails);

        return $leagueDetails->fresh();
    }
}
