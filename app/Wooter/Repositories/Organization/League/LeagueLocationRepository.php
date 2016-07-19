<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use Wooter\LeagueLocation;

class LeagueLocationRepository
{
    public function create(LeagueLocation $leagueLocation)
    {
        return $leagueLocation->push();
    }

    public function update(LeagueLocation $leagueLocation)
    {
        return $leagueLocation->push();
    }

    public function getById($leagueLocationId) {
        return LeagueLocation::whereId($leagueLocationId)->with('league', 'location')->first();
    }

    public function getByLeagueId($leagueId)
    {
        return LeagueLocation::whereLeagueId($leagueId)->with('league', 'location')->get();
    }
}
