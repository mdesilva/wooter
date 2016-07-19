<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Team;

class LeaguePlayerStatsTransformer extends Transformer
{
    public function transform($stats)
    {
        $stats = [
            'id' => $stats->id,
            'player_id' => $stats->player_id,
            'PTS' => $stats->PTS
        ];
        
        return $stats;
    }
}
