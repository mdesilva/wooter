<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Team\DivisionNotBelongToUser;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Wooter\Wooter\Repositories\Team\DivisionRepository;

class UpdateDivisionCommand extends Command implements SelfHandling
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
    private $divisionId;

    /**
     * Create a new command instance.
     *
     * @param $division_id
     * @param $name
     * @param $user_id
     */
    public function __construct($division_id, $name, $user_id)
    {
        $this->name = $name;
        $this->userId = $user_id;
        $this->divisionId = $division_id;
    }

    /**
     * Tries to create a league and save it in DB
     *
     * @param DivisionRepository $divisionRepository
     *
     * @return
     * @throws DivisionNotBelongToUser
     * @throws DivisionNotFound
     */
    public function handle(DivisionRepository $divisionRepository)
    {
        $division = $divisionRepository->getById($this->divisionId);

        if ( ! $division) {
            throw new DivisionNotFound;
        }

        if ($division->stage->competition->organization->user->id !== $this->userId)
        {
            throw new DivisionNotBelongToUser;
        }

        $division->name = $this->name;

        $divisionRepository->update($division);

        return $division;
    }
}
