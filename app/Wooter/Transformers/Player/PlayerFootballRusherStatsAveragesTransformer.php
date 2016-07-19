<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerFootballRusherStat;


class PlayerFootballRusherStatsAveragesTransformer extends Transformer
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
                'CAR' => $stats->avg('CAR') ? $stats->avg('CAR') : 'N/a',
                'TDS' => $stats->avg('YDS') ? $stats->avg('YDS') : 'N/a',
                'AVG' => $stats->avg('AVG') ? $stats->avg('AVG') : 'N/a',
                'TD' => $stats->avg('TD') ? $stats->avg('TD') : 'N/a',
                'LONG' => $stats->avg('LONG') ? $stats->avg('LONG') : 'N/a',
                'total_games' => $stats->count(),
                'CAR_rank' => $this->where('CAR', '>', $stats->avg('CAR')),
                'TDS_rank' => $this->where('TDS', '>', $stats->avg('TDS')),
                'AVG_rank' => $this->where('AVG', '>', $stats->avg('AVG')),
                'TD_rank' => $this->where('TD', '>', $stats->avg('TD')),
                'LONG_rank' => $this->where('LONG', '>', $stats->avg('LONG')),
            ];
        }
        
        return $response;
    }
    
    private function where($field, $operator, $value) {
        $ids = $this->all[$this->type]->lists('player_id')->toArray();

        $query = DB::table('player_football_rusher_stats');

        $players = $query->whereIn('player_football_rusher_stats.player_id', $ids)
                ->groupBy('player_football_rusher_stats.player_id')
                ->select('player_football_rusher_stats.player_id', DB::raw('AVG(player_football_rusher_stats.' . $field . ') as average'))
                ->lists('player_football_rusher_stats.average');
        
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
