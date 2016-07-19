<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;

class TeamSoftballStatsPercentagesTransformer extends Transformer
{
    public $leadingTeamStats;

    public function transform($stats)
    {
        $round = 2;
        $response = [
            'first_inning_points' => round($stats->avg('first_inning_score') * 100, $round),
            'second_inning_points' => round($stats->avg('second_inning_score') * 100, $round),
            'third_inning_points' => round($stats->avg('third_inning_score') * 100, $round),
            'fourth_inning_points' => round($stats->avg('fourth_inning_score') * 100, $round),
            'fifth_inning_points' => round($stats->avg('fifth_inning_score') * 100, $round),
            'sixth_inning_points' => round($stats->avg('sixth_inning_score') * 100, $round),
            'seventh_inning_points' => round($stats->avg('seventh_inning_score') * 100, $round),
            'eight_inning_points' => round($stats->avg('eight_inning_score') * 100, $round),
            'ninth_inning_points' => round($stats->avg('ninth_inning_score') * 100, $round),
            'points' => round($stats->avg('final_score') * 100, $round),
            'wins' => round($stats->avg('win') * 100, $round),
            'loss' => round($stats->avg('loss') * 100, $round),
            'draw' => round($stats->avg('draw') * 100, $round)
        ];
        
        return $response;
    }
}

