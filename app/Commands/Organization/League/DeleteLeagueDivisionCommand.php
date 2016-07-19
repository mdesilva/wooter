<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\DivisionRepository;
use Wooter\Wooter\Repositories\User\UserRepository;


class DeleteLeagueDivisionCommand extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $divisionId;
    /**
     * @var
     */
    private $userId;

    /**
     * @param $league_id
     * @param $division_id
     * @param $user_id
     */
    public function __construct($league_id,$division_id, $user_id)
    {
        $this->leagueId = $league_id;
        $this->divisionId = $division_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository   $leagueRepository
     * @param DivisionRepository $divisionRepository
     *
     * @param UserRepository     $userRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws DivisionNotFound
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

        if ($division->stage->competition->organization->id !== $league->id) {
            throw new NotPermissionException;
        }

        if ( ! $division->delete()) {
            throw new DatabaseException;
        }

        return true;
    }
}
