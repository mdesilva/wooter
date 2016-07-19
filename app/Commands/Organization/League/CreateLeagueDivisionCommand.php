<?php

namespace Wooter\Commands\Organization\League;

use Exception;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Division;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\DivisionRepository;
use Wooter\Wooter\Repositories\User\UserRepository;


class CreateLeagueDivisionCommand extends Command implements SelfHandling
{
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
    private $userId;

    /**
     * @param $league_id
     * @param $name
     * @param $user_id
     */
    public function __construct($league_id, $name, $user_id)
    {
        $this->leagueId = $league_id;
        $this->name = $name;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository   $leagueRepository
     *
     * @param DivisionRepository $divisionRepository
     * @param UserRepository     $userRepository
     *
     * @return Division
     * @throws Exception
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, DivisionRepository $divisionRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        if ($league->season_competitions) {
            $firstSeason = $league->season_competitions()->get()->first();

            if ($firstSeason->regular_stages) {
                $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                $division = new Division;
                $division->stage_id = $firstRegularStage->id;
                $division->stage_type = RegularStage::class;
                $division->name = $this->name;
                $divisionRepository->create($division);

                return $division;
            }
        }

        throw new Exception('The league must have a competition and a stage');
    }
}
