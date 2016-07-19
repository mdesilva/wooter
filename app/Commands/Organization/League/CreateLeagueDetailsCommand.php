<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueDetails;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueDetailsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class CreateLeagueDetailsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
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
    private $numberOfTeams;
    /**
     * @var
     */
    private $playersPerTeam;
    /**
     * @var
     */
    private $gamesPerTeam;
    /**
     * @var
     */
    private $maxPlayers;
    /**
     * @var
     */
    private $gameDuration;
    /**
     * @var
     */
    private $timePeriod;

    /**
     * @param $user_id
     * @param $league_id
     * @param $description
     * @param $number_of_teams
     * @param $players_per_team
     * @param $games_per_team
     * @param $max_players
     * @param $game_duration
     * @param $time_period
     */
    public function __construct($user_id,
                                $league_id,
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
        $this->description = $description;
        $this->numberOfTeams = $number_of_teams;
        $this->playersPerTeam = $players_per_team;
        $this->gamesPerTeam = $games_per_team;
        $this->maxPlayers = $max_players;
        $this->gameDuration = $game_duration;
        $this->timePeriod = $time_period;
    }

    /**
     * Tries to create a league and save it in DB
     *
     * @param LeagueDetailsRepository $leagueDetailsDetailsRepository
     * @param LeagueRepository $leagueRepository
     * @return bool
     * @throws LeagueNotBelongToUser
     * @throws LeagueNotFound
     */
    public function handle(LeagueDetailsRepository $leagueDetailsDetailsRepository, LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }

        $leagueDetails = new LeagueDetails();
        $leagueDetails->time_period = $this->timePeriod;
        $leagueDetails->game_duration = $this->gameDuration;
        $leagueDetails->max_players = $this->maxPlayers;
        $leagueDetails->games_per_team = $this->gamesPerTeam;
        $leagueDetails->players_per_team = $this->playersPerTeam;
        $leagueDetails->number_of_teams = $this->numberOfTeams;
        $leagueDetails->league_id = $this->leagueId;
        $leagueDetails->description = $this->description;

        $leagueDetailsDetailsRepository->create($leagueDetails);

        return $leagueDetails;
    }
}
