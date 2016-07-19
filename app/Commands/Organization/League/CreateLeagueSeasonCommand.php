<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Competition\Season\SeasonCompetitionsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\SeasonCompetition;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateLeagueSeasonCommand extends Command implements SelfHandling
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
    private $minTeams;
    /**
     * @var
     */
    private $maxFreeAgents;
    
    /**
     * @var
     */
    private $minFreeAgents;

    /**
     * @param $user_id
     * @param $league_id
     * @param $name
     * @param $starts_at
     * @param $ends_at
     * @param $registration_opens_at
     * @param $registration_closes_at
     * @param $max_teams
     * @param $min_teams
     * @param $max_free_agents
     * @param $min_free_agents
     */
    public function __construct($user_id, $league_id, $name, $starts_at, $ends_at, $registration_opens_at, $registration_closes_at,
                                $max_teams = null, $min_teams = null, $max_free_agents = null, $min_free_agents = null)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->name = $name;
        $this->startsAt = $starts_at;
        $this->endsAt = $ends_at;
        $this->registrationOpensAt = $registration_opens_at;
        $this->registrationClosesAt = $registration_closes_at;
        $this->maxTeams = $max_teams;
        $this->minTeams = $min_teams;
        $this->maxFreeAgents = $max_free_agents;
        $this->minFreeAgents = $min_free_agents;
    }

    /**
     * Execute the command.
     *
     * @param SeasonCompetitionsRepository $seasonsRepository
     * @param LeagueRepository             $leagueRepository
     *
     * @param RegularStageRepository      $RegularStageRepository
     * @param UserRepository               $userRepository
     *
     * @return SeasonCompetition
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(SeasonCompetitionsRepository $seasonsRepository,
                           LeagueRepository $leagueRepository,
                           RegularStageRepository $RegularStageRepository,
                           UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $season = DB::transaction(function () use ($seasonsRepository, $RegularStageRepository) {
            $season = new SeasonCompetition;
            $season->organization_id = $this->leagueId;
            $season->organization_type = LeagueOrganization::class;
            $season->name = $this->name;
            $season->starts_at = $this->startsAt;
            $season->ends_at = $this->endsAt;
            $season->registration_opens_at = $this->registrationOpensAt;
            $season->registration_closes_at = $this->registrationClosesAt;
            $season->max_teams = $this->maxTeams;
            $season->min_teams = $this->minTeams;
            $season->max_free_agents = $this->maxFreeAgents;
            $season->min_free_agents = $this->minFreeAgents;

            $seasonsRepository->create($season);

            $stage = new RegularStage;
            $stage->competition_id = $season->id;
            $stage->competition_type = SeasonCompetition::class;

            $RegularStageRepository->create($stage);


            return $season;
        });

        return $season;
    }
}
