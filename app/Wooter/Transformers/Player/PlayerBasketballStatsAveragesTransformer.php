<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerBasketballStat;
use Illuminate\Support\Facades\DB;


class PlayerBasketballStatsAveragesTransformer extends Transformer
{
    /*
     * @var
     */
    public $all;
    
    /*
     * @var
     */
    public $stat_name;
    
    /**
     * 
     * @var
     */
    public $type;
    
    public function transform($stats)
    {
        if ($this->stat_name) {
            $response = [
                $this->stat_name => $stats->avg($this->stat_name) ? $stats->avg($this->stat_name) : 'N/a'
            ];
        } else {
            $response = [
                'PPG' => $stats->avg('points') ? $stats->avg('points') : 'N/a',
                'FG' => $stats->avg('field_goals_made') ? $stats->avg('field_goals_made') : 'N/a',
                'FGA' => $stats->avg('field_goals_attempted') ? $stats->avg('field_goals_attempted') : 'N/a',
                '3FG' => $stats->avg('3_points_shots_made') ? $stats->avg('3_points_shots_made') : 'N/a',
                '3FGA' => $stats->avg('3_points_shots_attempted') ? $stats->avg('3_points_shots_attempted') : 'N/a',
                'FT' => $stats->avg('free_throws_made') ? $stats->avg('free_throws_made') : 'N/a',
                'FTA' => $stats->avg('free_throws_attempted') ? $stats->avg('free_throws_attempted') : 'N/a',
                'OFFR' => $stats->avg('offensive_rebounds') ? $stats->avg('offensive_rebounds') : 'N/a',
                'DEFR' => $stats->avg('defensive_rebounds') ? $stats->avg('defensive_rebounds') : 'N/a',
                'AST' => $stats->avg('assists') ? $stats->avg('assists') : 'N/a',
                'TURN' => $stats->avg('turnovers') ? $stats->avg('turnovers') : 'N/a',
                'STL' => $stats->avg('steals') ? $stats->avg('steals') : 'N/a',
                'BLK' => $stats->avg('blocked_shots') ? $stats->avg('blocked_shots') : 'N/a',
                'FL' => $stats->avg('personal_fouls') ? $stats->avg('personal_fouls') : 'N/a',
                'total_games' => $stats->count(),
                'PPG_rank' => $this->where('points', '>', $stats->avg('points')),
                'FG_rank' => $this->where('field_goals_made', '>', $stats->avg('field_goals_made')),
                '3FG_rank' => $this->where('3_points_shots_made', '>', $stats->avg('3_points_shots_made')),
                '3FGA_rank' => $this->where('3_points_shots_attempted', '>', $stats->avg('3_points_shots_attempted')),
                'FT_rank' => $this->where('free_throws_made', '>', $stats->avg('free_throws_made')),
                'FTA_rank' => $this->where('free_throws_attempted', '>', $stats->avg('free_throws_attempted')),
                'OFFR_rank' => $this->where('offensive_rebounds', '>', $stats->avg('offensive_rebounds')),
                'DEFR_rank' => $this->where('defensive_rebounds', '>', $stats->avg('defensive_rebounds')),
                'AST_rank' => $this->where('assists', '>', $stats->avg('assists')),
                'TURN_rank' => $this->where('turnovers', '>', $stats->avg('turnovers')),
                'STL_rank' => $this->where('steals', '>', $stats->avg('steals')),
                'BLK_rank' => $this->where('blocked_shots', '>', $stats->avg('blocked_shots')),
                'FL_rank' => $this->where('personal_fouls', '>', $stats->avg('personal_fouls'))
            ];
        }
        
        return $response;
    }
    
    private function where($field, $operator, $value) {
        $ids = $this->all[$this->type]->lists('player_id')->toArray();

        $query = DB::table('player_basketball_stats');

        $players = $query->whereIn('player_basketball_stats.player_id', $ids)
                ->groupBy('player_basketball_stats.player_id')
                ->select('player_basketball_stats.player_id', DB::raw('AVG(player_basketball_stats.' . $field . ') as average'))
                ->lists('player_basketball_stats.average');
        
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

