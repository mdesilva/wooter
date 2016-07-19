<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use Wooter\LeagueDetails;

class LeagueDetailsRepository
{

    public function create(LeagueDetails $leagueDetails)
    {
        return $leagueDetails->save();
    }

    public function update(LeagueDetails $leagueDetails)
    {
        return $leagueDetails->save();
    }

    public function getById($leagueDetailsId) {
        return LeagueDetails::whereId($leagueDetailsId)->first();
    }

}
