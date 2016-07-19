<?php

namespace Wooter\Commands\Team;

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

class CreateDivisionCommand extends Command implements SelfHandling
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
    private $leagueId;

    /**
     * Create a new command instance.
     *
     * @param $name
     * @param $user_id
     * @param $league_id
     */
    public function __construct($name, $user_id, $league_id)
    {
        $this->name = $name;
        $this->userId = $user_id;
        $this->leagueId = $league_id;
    }

    /**
     * Tries to create a division and save it in DB
     *
     * @param DivisionRepository $divisionRepository
     * @param LeagueRepository   $leagueRepository
     *
     * @param UserRepository     $userRepository
     *
     * @return bool
     * @throws Exception
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(DivisionRepository $divisionRepository, LeagueRepository $leagueRepository, UserRepository $userRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $division = new Division;

        $stage = $leagueRepository->getFirstStageByLeagueId($league->id);

        if ($stage) {
            $division->stage_id = $stage->id;
            $division->stage_type = RegularStage::class;
        } else {
            throw new Exception('The stage was not found for this league');
        }

        $division->name = $this->name;

        $divisionRepository->create($division);

        return $division;
    }
}
