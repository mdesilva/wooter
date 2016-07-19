<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueLocation;
use Wooter\Location;
use Wooter\Wooter\Exceptions\Organization\League\LeagueLocationNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Repositories\Organization\League\LeagueLocationRepository;

class ReadLeagueLocationCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     *
     * @internal param $league_location_id
     * @internal param $user_id
     */
    public function __construct($league_id)
    {
        $this->leagueId = $league_id;
    }

    /**
     * Execute the command.
     *
     * @return array
     */
    public function handle()
    {
        return LeagueLocation::whereLeagueId($this->leagueId)->get();
    }
}
