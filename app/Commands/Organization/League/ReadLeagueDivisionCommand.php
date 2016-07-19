<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Wooter\Wooter\Repositories\Team\DivisionRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class ReadLeagueDivisionCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $divisionId;

    /**
     * @var
     */
    private $leagueId;


    /**
     * Create a new command instance.
     *
     * @param $division_id
     * @param $league_id
     */
    public function __construct($division_id, $league_id)
    {
        $this->divisionId = $division_id;
        $this->leagueId = $league_id;
    }

    /**
     * Execute the command.
     *
     * @param DivisionRepository $divisionRepository
     * @param LeagueRepository   $leagueRepository
     *
     * @return
     * @throws DivisionNotFound
     * @throws LeagueNotFound
     * @throws NotPermissionException
     */
    public function handle(DivisionRepository $divisionRepository,
                           LeagueRepository $leagueRepository)
    {

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $division = $divisionRepository->getById($this->divisionId);

        if ( ! $division) {
            throw new DivisionNotFound;
        }

        if ($division->stage->competition->organization->id !== $league->id) {
            throw new NotPermissionException;
        }

        return $division;
    }
}

