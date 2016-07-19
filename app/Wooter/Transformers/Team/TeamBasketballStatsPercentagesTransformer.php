<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;

class TeamBasketballStatsPercentagesTransformer extends Transformer
{
    public $leadingTeamStats;

    public function transform($stats)
    {
        $round = 2;
        $response = [
            'first_quarter_points' => round($stats->avg('first_quarter_score') * 100, $round),
            'second_quarter_points' => round($stats->avg('second_quarter_score') * 100, $round),
            'third_quarter_points' => round($stats->avg('third_quarter_score') * 100, $round),
            'fourth_quarter_points' => round($stats->avg('fourth_quarter_score') * 100, $round),
            'points' => round($stats->avg('final_score') * 100, $round),
            'wins' => round($stats->avg('win') * 100, $round),
            'loss' => round($stats->avg('loss') * 100, $round),
            'draw' => round($stats->avg('draw') * 100, $round)
        ];
        
        return $response;
    }
}

