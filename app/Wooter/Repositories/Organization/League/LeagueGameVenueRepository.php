<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeagueGameVenue;
use Wooter\LeaguePrice;
use Wooter\GameVenueCompetition;

class LeagueGameVenueRepository
{

    public function create(LeagueGameVenue $leagueGameVenue)
    {
        return $leagueGameVenue->push();
    }

    public function update(LeagueGameVenue $leagueGameVenue)
    {
        return $leagueGameVenue->push();
    }

    public function getById($leagueGameVenueId) {
        return LeagueGameVenue::whereId($leagueGameVenueId)->first();
    }
    
    public function getByLeagueId($leagueId) {
        return LeagueGameVenue::where('league_id', $leagueId)->get();
    }

    public function getByLeagueIdAndGameVenueId($leagueId, $gameVenueId) {
        return LeagueGameVenue::whereLeagueId($leagueId)->whereGameVenueId($gameVenueId)->first();
    }

}
