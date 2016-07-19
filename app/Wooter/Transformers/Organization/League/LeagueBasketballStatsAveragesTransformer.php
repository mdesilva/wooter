<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerBasketballStat;
use DB;


class LeagueBasketballStatsAveragesTransformer extends Transformer
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
                'PPG' => $stats->avg('PTS') ? $stats->avg('PTS') : 'N/a',
                'OFF' => $stats->avg('OFF') ? $stats->avg('OFF') : 'N/a',
                'FG' => $stats->avg('FG') ? $stats->avg('FG') : 'N/a',
                'FT' => $stats->avg('FT') ? $stats->avg('FT') : 'N/a',
                '3PT' => $stats->avg('3PT') ? $stats->avg('3PT') : 'N/a',
                'PF' => $stats->avg('PF') ? $stats->avg('PF') : 'N/a',
                'TO' => $stats->avg('TO') ? $stats->avg('TO') : 'N/a',
                'STL' => $stats->avg('STL') ? $stats->avg('STL') : 'N/a',
                'REB' => $stats->avg('REB') ? $stats->avg('REB') : 'N/a',
                'AST' => $stats->avg('AST') ? $stats->avg('AST') : 'N/a',
                'BLK' => $stats->avg('BLK') ? $stats->avg('BLK') : 'N/a',
                'total_games' => $stats->count() ? $stats->count() : 'N/a',
                'PPG_rank' => $stats->avg('PTS') ? $this->where('PTS', '>=', $stats->avg('PTS')) : 'N/a',
                'OFF_rank' => $stats->avg('OFF') ? $this->where('OFF', '>=', $stats->avg('OFF')) : 'N/a',
                'FG_rank' => $stats->avg('FG') ? $this->where('FG', '>=', $stats->avg('FG')) : 'N/a',
                'FT_rank' => $stats->avg('FT') ? $this->where('FT', '>=', $stats->avg('FT')) : 'N/a',
                '3PT_rank' => $stats->avg('3PT') ? $this->where('3PT', '>=', $stats->avg('3PT')) : 'N/a',
                'PF_rank' => $stats->avg('PF') ? $this->where('PF', '>=', $stats->avg('PF')) : 'N/a',
                'TO_rank' => $stats->avg('TO') ? $this->where('TO', '<=', $stats->avg('TO')) : 'N/a',
                'STL_rank' => $stats->avg('STL') ? $this->where('STL', '>=', $stats->avg('STL')) : 'N/a',
                'REB_rank' => $stats->avg('REB') ? $this->where('REB', '>=', $stats->avg('REB')) : 'N/a',
                'AST_rank' => $stats->avg('AST') ? $this->where('AST', '>=', $stats->avg('AST')) : 'N/a',
                'BLK_rank' => $stats->avg('BLK') ? $this->where('BLK', '>=', $stats->avg('BLK')) : 'N/a'
            ];
        }
        
        return $response;
    }
    
    private function where($field, $operator, $value) {
        $ids = $this->league_stats->lists('id')->toArray();
        return PlayerBasketballStat::whereIn('id', $ids)->where($field, $operator, $value)->count();
    }
}
