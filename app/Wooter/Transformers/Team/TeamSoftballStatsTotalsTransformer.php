<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;

class TeamSoftballStatsTotalsTransformer extends Transformer
{
    public $leadingTeamStats;

    public function transform($stats)
    {
        $leadingWins = $this->leadingTeamStats->sum('win');
        $leadingLosses = $this->leadingTeamStats->sum('loss');
        $currentWins = $stats->sum('win');
        $currentLosses = $stats->sum('loss');
        
        
        $stats = [
            'first_inning_points' => $stats->sum('first_inning_score'),
            'second_inning_points' => $stats->sum('second_inning_score'),
            'third_inning_points' => $stats->sum('third_inning_score'),
            'fourth_inning_points' => $stats->sum('fourth_inning_score'),
            'fifth_inning_points' => $stats->sum('fifth_inning_score'),
            'sixth_inning_points' => $stats->sum('sixth_inning_score'),
            'seventh_inning_points' => $stats->sum('seventh_inning_score'),
            'eight_inning_points' => $stats->sum('eight_inning_score'),
            'ninth_inning_points' => $stats->sum('ninth_inning_score'),
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
