<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerSoftballPitcherStat;


class PlayerSoftballPitcherStatsAveragesTransformer extends Transformer
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
                'IP' => $stats->avg('IP') ? $stats->avg('IP') : 'N/a',
                'H' => $stats->avg('H') ? $stats->avg('H') : 'N/a',
                'R' => $stats->avg('R') ? $stats->avg('R') : 'N/a',
                'ER' => $stats->avg('ER') ? $stats->avg('ER') : 'N/a',
                'BB' => $stats->avg('BB') ? $stats->avg('BB') : 'N/a',
                'SO' => $stats->avg('SO') ? $stats->avg('SO') : 'N/a',
                'HR' => $stats->avg('HR') ? $stats->avg('HR') : 'N/a',
                'PCST' => $stats->avg('PCST') ? $stats->avg('PCST') : 'N/a',
                'ERA' => $stats->avg('ERA') ? $stats->avg('ERA') : 'N/a',
                'total_games' => $stats->count(),
                'IP_rank' => $this->where('IP', '>', $stats->avg('IP')),
                'H_rank' => $this->where('H', '>', $stats->avg('H')),
                'R_rank' => $this->where('R', '>', $stats->avg('R')),
                'ER_rank' => $this->where('ER', '>', $stats->avg('ER')),
                'BB_rank' => $this->where('BB', '>', $stats->avg('BB')),
                'SO_rank' => $this->where('SO', '>', $stats->avg('SO')),
                'HR_rank' => $this->where('HR', '>', $stats->avg('HR')),
                'PCST_rank' => $this->where('PCST', '>', $stats->avg('PCST')),
                'ERA_rank' => $this->where('ERA', '>', $stats->avg('ERA'))
            ];
        }
        
        return $response;
    }
    
    private function where($field, $operator, $value) {
        $ids = $this->all[$this->type]->lists('player_id')->toArray();

        $query = DB::table('player_softball_pitcher_stats');

        $players = $query->whereIn('player_softball_pitcher_stats.player_id', $ids)
                ->groupBy('player_softball_pitcher_stats.player_id')
                ->select('player_softball_pitcher_stats.player_id', DB::raw('AVG(player_softball_pitcher_stats.' . $field . ') as average'))
                ->lists('player_softball_pitcher_stats.average');
        
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

