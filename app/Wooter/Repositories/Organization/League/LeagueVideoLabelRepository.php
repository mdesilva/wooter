<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeagueVideoLabel;

class LeagueVideoLabelRepository
{


    public function create(LeagueVideoLabel $leagueVideoLabel)
    {
        return $leagueVideoLabel->save();
    }


    public function update(LeagueVideoLabel $leagueVideoLabel)
    {
        return $leagueVideoLabel->save();
    }

    public function getFromLeagueId($id)
    {
        return LeagueVideoLabel::where('league_id', intval($id))->get();

    }


    public function getById($id)
    {
        return LeagueVideoLabel::where('id', intval($id))->first();

    }
}
