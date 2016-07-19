<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;

class TeamBasketballStatsTotalsTransformer extends Transformer
{
    public $leadingTeamStats;

    public function transform($stats)
    {
        $leadingWins = $this->leadingTeamStats->sum('win');
        $leadingLosses = $this->leadingTeamStats->sum('loss');
        $currentWins = $stats->sum('win');
        $currentLosses = $stats->sum('loss');
        
        
        $stats = [
            'first_quarter_points' => $stats->sum('first_quarter_score'),
            'second_quarter_points' => $stats->sum('second_quarter_score'),
            'third_quarter_points' => $stats->sum('third_quarter_score'),
            'fourth_quarter_points' => $stats->sum('fourth_quarter_score'),
            'points' => $stats->sum('final_score'),
            'wins' => $stats->sum('win'),
            'loss' => $stats->sum('loss'),
            'draw' => $stats->sum('draw'),
            'GB' => $this->getGamesBehind($leadingWins, $currentWins, $leadingLosses, $currentLosses)
        ];
        
        return $stats;
    }
    
    private function getGamesBehind($leadingWins, $currentWins, $leadingLosses, $currentLosses) {
        $rule1 = ($leadingWins - $currentWins); 
        $rule2 = ($currentLosses - $leadingLosses);
        $rule3 = ($rule1 > 0 && $rule2 > 0) ? $rule1 / $rule2 : 'n/a';
        return ($rule3 == 'n/a') ? 'n/a' : $rule3 / 2;
    }
}

