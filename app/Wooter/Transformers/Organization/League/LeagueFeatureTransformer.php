<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\LeagueFeature;
use Wooter\Wooter\Transformers\Transformer;

class LeagueFeatureTransformer extends Transformer
{
    public function transform($leagueFeature)
    {
        return [
            'feature_id' => $leagueFeature->feature_id,
            'league_id' => $leagueFeature->league_id,
            'name' => $leagueFeature->feature->name,
            'name_localized' => $leagueFeature->feature->name_localized,
        ];
    }
}
