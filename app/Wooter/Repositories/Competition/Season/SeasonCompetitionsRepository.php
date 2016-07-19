<?php

namespace Wooter\Wooter\Repositories\Competition\Season;

use DB;
use Wooter\SeasonCompetition;

class SeasonCompetitionsRepository
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

}