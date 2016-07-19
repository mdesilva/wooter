<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerBasketballStat;

class TeamBasketballStatsAveragesTransformer extends Transformer
{
    public $leadingTeamStats;

    public function transform($stats)
    {
        $allGameStatsIds = $stats->lists('game_id');
        $uniqueGameIds = [];
        foreach ($allGameStatsIds as $uniqueGameId) {
            if ($uniqueGameId > 0) {
                $uniqueGameIds[$uniqueGameId] = $uniqueGameId;
            }
        }
        $numberOfGames = (count($uniqueGameIds) > 0) ? count($uniqueGameIds) : 1;
        
        $allTeamStatsIds = $stats->lists('team_id');
        $uniqueTeamIds = [];
        foreach ($allTeamStatsIds as $uniqueTeamId) {
            $uniqueTeamIds[$uniqueTeamId] = $uniqueTeamId;
        }
        
        $playerStats = PlayerBasketballStat::whereIn('team_id', $uniqueTeamIds)->get();
        $round = 2;
        $response = [
            'first_quarter_points' => round($stats->avg('first_quarter_score'), $round),
            'second_quarter_points' => round($stats->avg('second_quarter_score'), $round),
            'third_quarter_points' => round($stats->avg('third_quarter_score'), $round),
            'fourth_quarter_points' => round($stats->avg('fourth_quarter_score'), $round),
            'points' => round($stats->avg('final_score'), $round),
            'wins' => round($stats->avg('win'), $round),
            'loss' => round($stats->avg('loss'), $round),
            'draw' => round($stats->avg('draw'), $round),
            'player_stats' => [
                'PTS' => $playerStats->sum('points') ? round($playerStats->sum('points') / $numberOfGames, $round) : 0,
                'FG' => $playerStats->sum('field_goals_made') ? round($playerStats->sum('field_goals_made') / $numberOfGames, $round) : 0,
                'FGA' => $playerStats->sum('field_goals_attempted') ? round($playerStats->sum('field_goals_attempted') / $numberOfGames, $round) : 0,
                '3FG' => $playerStats->sum('3_points_shots_made') ? round($playerStats->sum('3_points_shots_made') / $numberOfGames, $round) : 0,
                '3FGA' => $playerStats->sum('3_points_shots_attempted') ? round($playerStats->sum('3_points_shots_attempted') / $numberOfGames, $round) : 0,
                'FT' => $playerStats->sum('free_throws_made') ? round($playerStats->sum('free_throws_made') / $numberOfGames, $round) : 0,
                'FTA' => $playerStats->sum('free_throws_attempted') ? round($playerStats->sum('free_throws_attempted') / $numberOfGames, $round) : 0,
                'OFFRB' => $playerStats->sum('offensive_rebounds') ? round($playerStats->sum('offensive_rebounds') / $numberOfGames, $round) : 0,
                'DEFRB' => $playerStats->sum('defensive_rebounds') ? round($playerStats->sum('defensive_rebounds') / $numberOfGames, $round) : 0,
                'AST' => $playerStats->sum('assists') ? round($playerStats->sum('assists') / $numberOfGames, $round) : 0,
                'TURN' => $playerStats->sum('turnovers') ? round($playerStats->sum('turnovers') / $numberOfGames, $round) : 0,
                'STL' => $playerStats->sum('steals') ? round($playerStats->sum('steals') / $numberOfGames, $round) : 0,
                'BLK' => $playerStats->sum('blocked_shots') ? round($playerStats->sum('blocked_shots') / $numberOfGames, $round) : 0,
                'FL' => $playerStats->sum('personal_fouls') ? round($playerStats->sum('personal_fouls') / $numberOfGames, $round) : 0
            ]
        ];
        
        return $response;
    }
}

