<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerFootballQuarterbackStat;


class PlayerFootballQuarterbackStatsAveragesTransformer extends Transformer
{
    /*
     * @var
     */
    public $all;
    
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
                'COMP' => $stats->avg('COMP') ? $stats->avg('COMP') : 'N/a',
                'ATT' => $stats->avg('ATT') ? $stats->avg('ATT') : 'N/a',
                'PCT' => $stats->avg('PCT') ? $stats->avg('PCT') : 'N/a',
                'YDS' => $stats->avg('YDS') ? $stats->avg('YDS') : 'N/a',
                'AVG' => $stats->avg('AVG') ? $stats->avg('AVG') : 'N/a',
                'TD' => $stats->avg('TD') ? $stats->avg('TD') : 'N/a',
                'INT' => $stats->avg('INT') ? $stats->avg('INT') : 'N/a',
                'SACKS' => $stats->avg('SACKS') ? $stats->avg('SACKS') : 'N/a',
                'QBR' => $stats->avg('ABR') ? $stats->avg('ABR') : 'N/a',
                'total_games' => $stats->count(),
                'COMP_rank' => $this->where('COMP', '>', $stats->avg('COMP')),
                'ATT_rank' => $this->where('ATT', '>', $stats->avg('ATT')),
                'PCT_rank' => $this->where('PCT', '>', $stats->avg('PCT')),
                'YDS_rank' => $this->where('YDS', '>', $stats->avg('YDS')),
                'AVG_rank' => $this->where('AVG', '>', $stats->avg('AVG')),
                'TD_rank' => $this->where('TD', '>', $stats->avg('TD')),
                'INT_rank' => $this->where('INT', '>', $stats->avg('INT')),
                'SACKS_rank' => $this->where('SACKS', '>', $stats->avg('SACKS')),
                'QBR_rank' => $this->where('QBR', '>', $stats->avg('QBR'))
            ];
        }
        
        return $response;
    }
    
    private function where($field, $operator, $value) {
        $ids = $this->all[$this->type]->lists('player_id')->toArray();

        $query = DB::table('player_football_quarterback_stats');

        $players = $query->whereIn('player_football_quarterback_stats.player_id', $ids)
                ->groupBy('player_football_quarterback_stats.player_id')
                ->select('player_football_quarterback_stats.player_id', DB::raw('AVG(player_football_quarterback_stats.' . $field . ') as average'))
                ->lists('player_football_quarterback_stats.average');
        
        $count = 1;
        switch ($operator) {
            case '>':
                foreach ($players as $player) {
                    if ($player > $value) {
                        $count++;
                    }
                }
                break;
            case '<': 
                foreach ($players as $player) {
                    if ($player < $value) {
                        $count++;
                    }
                }
        }
        
        return $count;
    }
}

