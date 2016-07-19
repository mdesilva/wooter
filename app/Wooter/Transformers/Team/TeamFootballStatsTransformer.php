<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;

class TeamFootballStatsTransformer extends Transformer
{

    public function transform($stats)
    {
        $stats = [
            'team_id' => $stats->team_id,
            'game_id' => $stats->game_id,
            'first_quarter_score' => $stats->first_quarter_score,
            'second_quarter_score' => $stats->second_quarter_score,
            'third_quarter_score' => $stats->third_quarter_score,
            'fourth_quarter_score' => $stats->fourth_quarter_score,
            'final_score' => $stats->final_score
        ];
        
        return $stats;
    }
}

