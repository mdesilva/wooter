<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\Role;
use Wooter\SeasonCompetition;
use Wooter\UserRole;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Competition\Season\SeasonCompetitionsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $sport_id;

    /**
     * Create a new command instance.
     *
     * @param      $name
     * @param      $sport_id
     * @param      $user_id
     */
    public function __construct($name, $sport_id, $user_id)
    {
        $this->name = $name;
        $this->userId = $user_id;
        $this->sport_id = $sport_id;
    }

    /**
     * Tries to create a league and save it in DB
     *
     * @param LeagueRepository             $leagueRepository
     * @param UserRepository               $userRepository
     *
     * @param SeasonCompetitionsRepository $seasonCompetitionsRepository
     * @param RegularStageRepository      $regularStageRepository
     *
     * @return bool
     * @throws UserHasNoOrganization
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, UserRepository $userRepository,
                           SeasonCompetitionsRepository $seasonCompetitionsRepository,
                           RegularStageRepository $regularStageRepository)
    {
        $user = $userRepository->getById($this->userId);
        
        if ( ! $user)
        {
            throw new UserNotFound;
        }

        $league = DB::transaction(function () use ($leagueRepository, $seasonCompetitionsRepository, $regularStageRepository, $user) {

            $league = new LeagueOrganization;
            $league->user_id = $user->id;
            $league->name = $this->name;
            $league->sport_id = $this->sport_id;
            $leagueRepository->create($league);

            if ( ! $user->isOrganization()) {
                $userRole = new UserRole;
                $userRole->user_id = $user->id;
                $userRole->role_id = Role::ORGANIZATION;
                $userRole->save();
            }

            $season = new SeasonCompetition;
            $season->organization_id = $league->id;
            $season->name = $this->name . ' Season';
            $season->organization_type = LeagueOrganization::class;
            $seasonCompetitionsRepository->create($season);

            $regular = new RegularStage();
            $regular->competition_id = $season->id;
            $regular->competition_type = SeasonCompetition::class;
            $regularStageRepository->create($regular);

            return $league;
        });
        
        return $league;
    }
}
