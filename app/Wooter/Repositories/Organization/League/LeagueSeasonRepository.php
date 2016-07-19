<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeaguePrice;
use Wooter\SeasonCompetition;

class LeagueSeasonRepository
{

    public function create(SeasonCompetition $season)
    {
        return $season->save();
    }

    public function update(SeasonCompetition $season)
    {
        return $season->save();
    }

    public function getById($seasonId) {
        return SeasonCompetition::whereId($seasonId)->first();
    }
    
    public function getByLeagueId($leagueId) {
        return SeasonCompetition::where('league_id', $leagueId)->get();
    }
    
    public function getBySeasonId($leagueId, $seasonId) {
        return SeasonCompetition::whereId($seasonId)->where('league_id', $leagueId)->first();
    }

}
