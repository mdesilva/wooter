<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueBasicsNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Repositories\Organization\League\LeagueBasicsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Exception;

class ReadLeagueBasicsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     */
    public function __construct($league_id)
    {
        $this->leagueId = $league_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository $leagueRepository
     *
     * @return mixed
     * @throws LeagueBasicsNotFound
     * @throws LeagueNotFound
     * @internal param LeagueBasicsRepository $leagueBasicsRepository
     */
    public function handle(LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if( ! $league->basics)
        {
            throw new LeagueBasicsNotFound;
        }
        return  $league->basics;
    }
}
