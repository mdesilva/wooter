<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Competition\Season\SeasonCompetitionNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Competition\Season\SeasonCompetitionsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdateLeagueSeasonCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $startsAt;
    /**
     * @var
     */
    private $endsAt;
    /**
     * @var
     */
    private $registrationOpensAt;
    /**
     * @var
     */
    private $registrationClosesAt;
    /**
     * @var
     */
    private $maxTeams;
    /**
     * @var
     */
    private $maxFreeAgents;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $seasonId;
    /**
     * @var
     */
    private $minTeams;
    /**
     * @var
     */
    private $minFreeAgents;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $name
     * @param $starts_at
     * @param $ends_at
     * @param $registration_opens_at
     * @param $min_teams
     * @param $min_free_agents
     *
     * @internal param $registration_closes_at
     * @internal param $max_teams
     * @internal param $max_free_agents
     * @internal param $league_id
     *
     * @internal param $season_id
     *
     * @internal param $league_season_id
     * @internal param $source
     */
    public function __construct($user_id, $name, $starts_at, $ends_at, $registration_opens_at, $min_teams = null, $min_free_agents = null,
                                $registration_closes_at, $max_teams = null, $max_free_agents = null, $league_id, $season_id)
    {
        $this->userId = $user_id;
        $this->name = $name;
        $this->startsAt = $starts_at;
        $this->endsAt = $ends_at;
        $this->registrationOpensAt = $registration_opens_at;
        $this->registrationClosesAt = $registration_closes_at;
        $this->maxTeams = $max_teams;
        $this->maxFreeAgents = $max_free_agents;
        $this->leagueId = $league_id;
        $this->seasonId = $season_id;
        $this->minTeams = $min_teams;
        $this->minFreeAgents = $min_free_agents;
    }

    /**
     * Execute the command.
     *
     * @param SeasonCompetitionsRepository $seasonCompetitionsRepository
     * @param LeagueRepository             $leagueRepository
     *
     * @param UserRepository               $userRepository
     *
     * @return
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws SeasonCompetitionNotFound
     * @throws UserNotFound
     * @internal param LeagueSeasonRepository $leagueSeasonRepository
     */
    public function handle(SeasonCompetitionsRepository $seasonCompetitionsRepository, LeagueRepository $leagueRepository,  UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $season = $seasonCompetitionsRepository->getById($this->seasonId);

        if ( ! $season)
        {
            throw new SeasonCompetitionNotFound;
        }

        if ($season->organization->id != $league->id) {
            throw new NotPermissionException;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $season->name = $this->name;
        $season->starts_at = $this->startsAt;
        $season->ends_at = $this->endsAt;
        $season->registration_opens_at = $this->registrationOpensAt;
        $season->registration_closes_at = $this->registrationClosesAt;
        $season->max_teams = $this->maxTeams;
        $season->min_teams = $this->minTeams;
        $season->max_free_agents = $this->maxFreeAgents;
        $season->min_free_agents = $this->minFreeAgents;

        $seasonCompetitionsRepository->update($season);

        return $season;
    }
}
