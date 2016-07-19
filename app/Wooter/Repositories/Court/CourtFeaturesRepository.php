<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\CourtFeature;

class CourtFeaturesRepository
{

    public function create(CourtFeature $feature)
    {
        return $feature->save();
    }

    public function update(CourtFeature $feature)
    {
        return $feature->save();
    }

    public function getById($feature_id)
    {
        return CourtFeature::whereId($feature_id)->first();
    }
}

