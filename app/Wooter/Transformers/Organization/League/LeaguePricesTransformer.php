<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeaguePricesTransformer extends Transformer
{
    public function transform($leaguePrice)
    {

        return [
            'id' => $leaguePrice->id,
            'league_id' => $leaguePrice->league_id,
            'price' => $leaguePrice->price,
            'description' => $leaguePrice->description,
            'name' => $leaguePrice->name,
            'url' => $leaguePrice->url,
        ];
    }
}
