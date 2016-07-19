<?php

namespace Wooter\Commands\Organization\League;

use Exception;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Division;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\DivisionRepository;
use Wooter\Wooter\Repositories\User\UserRepository;


class UpdateLeagueDivisionCommand extends Command implements SelfHandling
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
     * @var
     */
    private $divisionId;

    /**
     * @param $league_id
     * @param $name
     * @param $user_id
     * @param $division_id
     */
    public function __construct($league_id, $name, $user_id, $division_id)
    {
        $this->leagueId = $league_id;
        $this->name = $name;
        $this->userId = $user_id;
        $this->divisionId = $division_id;
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

        $division = $divisionRepository->getById($this->divisionId);

        if ( ! $division) {
            throw new DivisionNotFound;
        }

        $division->name = $this->name;

        $divisionRepository->update($division);

        return $division->fresh();
    }
}
