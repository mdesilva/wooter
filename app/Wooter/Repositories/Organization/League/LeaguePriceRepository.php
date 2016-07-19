<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeaguePrice;

class LeaguePriceRepository
{

    public function create(LeaguePrice $leaguePrice)
    {
        return $leaguePrice->push();
    }

    public function update(LeaguePrice $leaguePrice)
    {
        return $leaguePrice->push();
    }

    public function getById($leaguePriceId) {
        return LeaguePrice::whereId($leaguePriceId)->first();
    }

    public function getByLeagueIdWithPagination($leagueId)
    {
        return LeaguePrice::whereLeagueId($leagueId)->paginate();
    }

    public function getByLeagueId($leagueId)
    {
        return LeaguePrice::whereLeagueId($leagueId)->get();
    }

}
