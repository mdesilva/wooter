<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerSoftballBatterStat;


class PlayerSoftballBatterStatsAveragesTransformer extends Transformer
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
                'AB' => $stats->avg('AB') ? $stats->avg('AB') : 'N/a',
                'R' => $stats->avg('R') ? $stats->avg('R') : 'N/a',
                'H' => $stats->avg('H') ? $stats->avg('H') : 'N/a',
                'RBI' => $stats->avg('RBI') ? $stats->avg('RBI') : 'N/a',
                'BB' => $stats->avg('BB') ? $stats->avg('BB') : 'N/a',
                'SO' => $stats->avg('SO') ? $stats->avg('SO') : 'N/a',
                'HBP' => $stats->avg('HBP') ? $stats->avg('HBP') : 'N/a',
                'SF' => $stats->avg('SF') ? $stats->avg('SF') : 'N/a',
                'TB' => $stats->avg('TB') ? $stats->avg('TB') : 'N/a',
                'AVG' => $stats->avg('AVG') ? $stats->avg('AVG') : 'N/a',
                'OBP' => $stats->avg('OBP') ? $stats->avg('OBP') : 'N/a',
                'SLG' => $stats->avg('SLG') ? $stats->avg('SLG') : 'N/a',
                'total_games' => $stats->count(),
                'AB_rank' => $this->where('AB', '>', $stats->avg('AB')),
                'R_rank' => $this->where('R', '>', $stats->avg('R')),
                'H_rank' => $this->where('H', '>', $stats->avg('H')),
                'RBI_rank' => $this->where('RBI', '>', $stats->avg('RBI')),
                'BB_rank' => $this->where('BB', '>', $stats->avg('BB')),
                'SO_rank' => $this->where('SO', '>', $stats->avg('SO')),
                'HBP_rank' => $this->where('HBP', '>', $stats->avg('HBP')),
                'SF_rank' => $this->where('SF', '>', $stats->avg('SF')),
                'TB_rank' => $this->where('TB', '>', $stats->avg('TB')),
                'AVG_rank' => $this->where('AVG', '>', $stats->avg('AVG')),
                'OBP_rank' => $this->where('OBP', '>', $stats->avg('OBP')),
                'SLG_rank' => $this->where('SLG', '>', $stats->avg('SLG'))
            ];
        }
        
        return $response;
    }
    
    private function where($field, $operator, $value) {
        $ids = $this->all[$this->type]->lists('player_id')->toArray();

        $query = DB::table('player_softball_batter_stats');

        $players = $query->whereIn('player_softball_batter_stats.player_id', $ids)
                ->groupBy('player_softball_batter_stats.player_id')
                ->select('player_softball_batter_stats.player_id', DB::raw('AVG(player_softball_batter_stats.' . $field . ') as average'))
                ->lists('player_softball_batter_stats.average');
        
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