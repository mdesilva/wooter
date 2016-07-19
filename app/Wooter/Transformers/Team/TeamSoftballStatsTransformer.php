<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;

class TeamSoftballStatsTransformer extends Transformer
{

    public function transform($stats)
    {
        $stats = [
            'team_id' => $stats->team_id,
            'game_id' => $stats->game_id,
            'first_inning_score' => $stats->first_inning_score,
            'second_inning_score' => $stats->second_inning_score,
            'third_inning_score' => $stats->third_inning_score,
            'fourth_inning_score' => $stats->fourth_inning_score,
            'fifth_inning_score' => $stats->fifth_inning_score,
            'sixth_inning_score' => $stats->sixth_inning_score,
            'seventh_inning_score' => $stats->seventh_inning_score,
            'eight_inning_score' => $stats->eight_inning_score,
            'ninth_inning_score' => $stats->ninth_inning_score
        ];
        
        return $stats;
    }
}

