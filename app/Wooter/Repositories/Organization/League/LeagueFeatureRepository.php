<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use Wooter\LeagueFeature;

class LeagueFeatureRepository
{

    public function create(LeagueFeature $leagueFeature)
    {
        return $leagueFeature->push();
    }

    public function update(LeagueFeature $leagueFeature)
    {
        return $leagueFeature->push();
    }

    public function getById($leagueFeatureId) {
        return LeagueFeature::whereId($leagueFeatureId)->first();
    }

    public function getByLeagueId($leagueId) {
        return LeagueFeature::whereLeagueId($leagueId)->get();
    }

    public function getByLeagueIdAndFeatureId($leagueId, $featureId) {
        return LeagueFeature::whereLeagueId($leagueId)->whereFeatureId($featureId)->first();
    }

}
