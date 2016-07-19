<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Wooter\Wooter\Exceptions\Team\TeamDivisionNotBelongToUser;
use Wooter\Wooter\Exceptions\Team\TeamDivisionNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Team\DivisionRepository;
use Wooter\Wooter\Repositories\Team\TeamDivisionRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateDivisionTeamsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $divisionId;
    /**
     * @var
     */
    private $teams;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $division_id
     * @param $teams
     * @param $user_id
     */
    public function __construct($division_id, $teams, $user_id)
    {
        $this->divisionId = $division_id;
        $this->teams = $teams;
        $this->userId = $user_id;
    }


    /**
     * @param DivisionRepository $divisionRepository
     * @param UserRepository     $userRepository
     *
     * @param TeamRepository     $teamRepository
     *
     * @throws DivisionNotFound
     * @throws NotPermissionException
     * @throws TeamNotFound
     * @throws UserNotFound
     */
    public function handle(DivisionRepository $divisionRepository, UserRepository $userRepository, TeamRepository $teamRepository)
    {
        $division = $divisionRepository->getById($this->divisionId);

        if ( ! $division) {
            throw new DivisionNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($division->stage->competition->organization->id)) {
            throw new NotPermissionException;
        }

        foreach ($this->teams as $teamId) {

            $team = $teamRepository->getById($teamId);

            if ( ! $team) {
                throw new TeamNotFound;
            }

            $team->divisions()->detach($division->stage->divisions()->lists('id')->toArray());

            $team->divisions()->attach($this->divisionId);
        }
    }
}
