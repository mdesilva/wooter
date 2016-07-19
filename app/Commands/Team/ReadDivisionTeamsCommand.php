<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Wooter\Wooter\Repositories\Team\DivisionRepository;

class ReadDivisionTeamsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $divisionId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $division_id
     * @param $user_id
     */
    public function __construct($division_id, $user_id)
    {
        $this->divisionId = $division_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param DivisionRepository $divisionRepository
     *
     * @return
     * @throws DivisionNotFound
     * @throws NotPermissionException
     * @internal param DivisionRepository $leagueRepository
     *
     */
    public function handle(DivisionRepository $divisionRepository)
    {
        $division = $divisionRepository->getById($this->divisionId);

        if ( ! $division) {
            throw new DivisionNotFound;
        }

        return $division->teams;
    }
}
