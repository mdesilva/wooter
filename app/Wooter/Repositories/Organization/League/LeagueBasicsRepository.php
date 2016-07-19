<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeagueBasics;

class LeagueBasicsRepository
{

    public function create(LeagueBasics $leagueBasics)
    {
        return $leagueBasics->push();
    }

    public function update(LeagueBasics $leagueBasics)
    {
        return $leagueBasics->push();
    }

    public function getById($leagueBasicsId) {
        return LeagueBasics::whereId($leagueBasicsId)->first();
    }

}
