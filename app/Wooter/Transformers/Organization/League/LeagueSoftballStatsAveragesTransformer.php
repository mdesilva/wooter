<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerBasketballStat;
use DB;


class LeagueSoftballStatsAveragesTransformer extends Transformer
{
    /*
     * @var
     */
    public $league_stats;
    
    /*
     * @var
     */
    public $stat_name;
    
    public function transform($stats)
    {
        if ($this->stat_name) {
            $response = [
                $this->stat_name => $stats->avg($this->stat_name) ? $stats->avg($this->stat_name) : 'N/a'
            ];
        } else {
            $response = [
                'AVG' => $stats->avg('AVG') ? $stats->avg('AVG') : 'N/a',
                'AB' => $stats->avg('AB') ? $stats->avg('AB') : 'N/a',
                'R' => $stats->avg('R') ? $stats->avg('R') : 'N/a',
                'H' => $stats->avg('H') ? $stats->avg('H') : 'N/a',
                'RBI' => $stats->avg('RBI') ? $stats->avg('RBI') : 'N/a',
                '2B' => $stats->avg('2B') ? $stats->avg('2B') : 'N/a',
                '3B' => $stats->avg('3B') ? $stats->avg('3B') : 'N/a',
                'HR' => $stats->avg('HR') ? $stats->avg('HR') : 'N/a',
                'BB' => $stats->avg('BB') ? $stats->avg('BB') : 'N/a',
                'K' => $stats->avg('K') ? $stats->avg('K') : 'N/a',
                'SB' => $stats->avg('SB') ? $stats->avg('SB') : 'N/a',
                'total_games' => $stats->count() ? $stats->count() : 'N/a',
                'AVG_rank' => $stats->avg('AVG') ? $this->where('AVG', '>=', $stats->avg('AVG')) : 'N/a',
                'AB_rank' => $stats->avg('AB') ? $this->where('AB', '>=', $stats->avg('AB')) : 'N/a',
                'R_rank' => $stats->avg('R') ? $this->where('R', '>=', $stats->avg('R')) : 'N/a',
                'H_rank' => $stats->avg('H') ? $this->where('H', '>=', $stats->avg('H')) : 'N/a',
                'RBI_rank' => $stats->avg('RBI') ? $this->where('RBI', '>=', $stats->avg('RBI')) : 'N/a',
                '2B_rank' => $stats->avg('2B') ? $this->where('2B', '>=', $stats->avg('2B')) : 'N/a',
                '3B_rank' => $stats->avg('3B') ? $this->where('3B', '>=', $stats->avg('3B')) : 'N/a',
                'HR_rank' => $stats->avg('HR') ? $this->where('HR', '>=', $stats->avg('HR')) : 'N/a',
                'BB_rank' => $stats->avg('BB') ? $this->where('BB', '>=', $stats->avg('BB')) : 'N/a',
                'K_rank' => $stats->avg('K') ? $this->where('K', '>=', $stats->avg('K')) : 'N/a',
                'SB_rank' => $stats->avg('SB') ? $this->where('SB', '>=', $stats->avg('SB')) : 'N/a'
            ];
        }
        
        return $response;
    }
    
    private function where($field, $operator, $value) {
        $ids = $this->league_stats->lists('id')->toArray();
        return PlayerBasketballStat::whereIn('id', $ids)->where($field, $operator, $value)->count();
    }
}
