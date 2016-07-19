<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerBasketballStat;
use DB;


class LeagueFootballStatsAveragesTransformer extends Transformer
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
                'Comp' => $stats->avg('Comp') ? $stats->avg('Comp') : 'N/a',
                'Att' => $stats->avg('Att') ? $stats->avg('Att') : 'N/a',
                'Pct' => $stats->avg('Pct') ? $stats->avg('Pct') : 'N/a',
                'Yds' => $stats->avg('Yds') ? $stats->avg('Yds') : 'N/a',
                'YA' => $stats->avg('YA') ? $stats->avg('YA') : 'N/a',
                'TD' => $stats->avg('TD') ? $stats->avg('TD') : 'N/a',
                'Int' => $stats->avg('Int') ? $stats->avg('Int') : 'N/a',
                'Sack' => $stats->avg('Sack') ? $stats->avg('Sack') : 'N/a',
                'YdsL' => $stats->avg('YdsL') ? $stats->avg('YdsL') : 'N/a',
                'QBRat' => $stats->avg('QBRat') ? $stats->avg('QBRat') : 'N/a',
                'total_games' => $stats->count() ? $stats->count() : 'N/a',
                'Comp_rank' => $stats->avg('Comp') ? $this->where('Comp', '>=', $stats->avg('Comp')) : 'N/a',
                'Att_rank' => $stats->avg('Att') ? $this->where('Att', '>=', $stats->avg('Att')) : 'N/a',
                'Pct_rank' => $stats->avg('Pct') ? $this->where('Pct', '>=', $stats->avg('Pct')) : 'N/a',
                'Yds_rank' => $stats->avg('Yds') ? $this->where('Yds', '>=', $stats->avg('Yds')) : 'N/a',
                'YA_rank' => $stats->avg('YA') ? $this->where('YA', '>=', $stats->avg('YA')) : 'N/a',
                'TD_rank' => $stats->avg('TD') ? $this->where('TD', '>=', $stats->avg('TD')) : 'N/a',
                'Int_rank' => $stats->avg('Int') ? $this->where('Int', '<=', $stats->avg('Int')) : 'N/a',
                'Sack_rank' => $stats->avg('Sack') ? $this->where('Sack', '>=', $stats->avg('Sack')) : 'N/a',
                'YdsL_rank' => $stats->avg('YdsL') ? $this->where('YdsL', '>=', $stats->avg('YdsL')) : 'N/a',
                'QBRat_rank' => $stats->avg('QBRat') ? $this->where('QBRat', '>=', $stats->avg('QBRat')) : 'N/a'
            ];
        }
        
        return $response;
    }
    
    private function where($field, $operator, $value) {
        $ids = $this->league_stats->lists('id')->toArray();
        return PlayerBasketballStat::whereIn('id', $ids)->where($field, $operator, $value)->count();
    }
}

