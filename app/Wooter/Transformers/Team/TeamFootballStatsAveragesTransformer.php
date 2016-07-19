<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerFootballQuarterbackStat;
use Wooter\PlayerFootballReceiverStat;
use Wooter\PlayerFootballDefenderStat;
use Wooter\PlayerFootballRusherStat;

class TeamFootballStatsAveragesTransformer extends Transformer
{

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
        
        $quarterbackStats = PlayerFootballQuarterbackStat::whereIn('team_id', $uniqueTeamIds)->get();
        $receiverStats = PlayerFootballReceiverStat::whereIn('team_id', $uniqueTeamIds)->get();
        $defenderStats = PlayerFootballDefenderStat::whereIn('team_id', $uniqueTeamIds)->get();
        $rusherStats = PlayerFootballRusherStat::whereIn('team_id', $uniqueTeamIds)->get();
        
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
                'quarterbacks' => [
                    'COMP' => $quarterbackStats->sum('COMP') ? round($quarterbackStats->sum('COMP') / $numberOfGames, $round) : 0,
                    'ATT' => $quarterbackStats->sum('ATT') ? round($quarterbackStats->sum('ATT') / $numberOfGames, $round) : 0,
                    'PCT' => $quarterbackStats->sum('PCT') ? round($quarterbackStats->sum('PCT') / $numberOfGames, $round) : 0,
                    'YDS' => $quarterbackStats->sum('YDS') ? round($quarterbackStats->sum('YDS') / $numberOfGames, $round) : 0,
                    'AVG' => $quarterbackStats->sum('AVG') ? round($quarterbackStats->sum('AVG') / $numberOfGames, $round) : 0,
                    'TD' => $quarterbackStats->sum('TD') ? round($quarterbackStats->sum('TD') / $numberOfGames, $round) : 0,
                    'INT' => $quarterbackStats->sum('INT') ? round($quarterbackStats->sum('INT') / $numberOfGames, $round) : 0,
                    'SACKS' => $quarterbackStats->sum('SACKS') ? round($quarterbackStats->sum('SACKS') / $numberOfGames, $round) : 0,
                    'QBR' => $quarterbackStats->sum('QBR') ? round($quarterbackStats->sum('QBR') / $numberOfGames, $round) : 0,
                ],
                
                'receivers' => [
                    'REC' => $receiverStats->sum('REC') ? round($receiverStats->sum('REC') / $numberOfGames, $round) : 0,
                    'YDS' => $receiverStats->sum('YDS') ? round($receiverStats->sum('YDS') / $numberOfGames, $round) : 0,
                    'AVG' => $receiverStats->sum('AVG') ? round($receiverStats->sum('AVG') / $numberOfGames, $round) : 0,
                    'TD' => $receiverStats->sum('TD') ? round($receiverStats->sum('TD') / $numberOfGames, $round) : 0,
                    'LONG' => $receiverStats->sum('LONG') ? round($receiverStats->sum('LONG') / $numberOfGames, $round) : 0,
                    'TGTS' => $receiverStats->sum('TGTS') ? round($receiverStats->sum('TGTS') / $numberOfGames, $round) : 0,
                ],
                
                'defenders' => [
                    'INT' => $defenderStats->sum('INT') ? round($defenderStats->sum('INT') / $numberOfGames, $round) : 0,
                    'YDS' => $defenderStats->sum('YDS') ? round($defenderStats->sum('YDS') / $numberOfGames, $round) : 0,
                    'TKLS' => $defenderStats->sum('TKLS') ? round($defenderStats->sum('TKLS') / $numberOfGames, $round) : 0,
                    'SACKS' => $defenderStats->sum('SACKS') ? round($defenderStats->sum('SACKS') / $numberOfGames, $round) : 0,
                    'TD' => $defenderStats->sum('TD') ? round($defenderStats->sum('TD') / $numberOfGames, $round) : 0,
                ],
                
                'rushers' => [
                    'CAR' => $rusherStats->sum('CAR') ? round($rusherStats->sum('CAR') / $numberOfGames, $round) : 0,
                    'YDS' => $rusherStats->sum('YDS') ? round($rusherStats->sum('YDS') / $numberOfGames, $round) : 0,
                    'AVG' => $rusherStats->sum('AVG') ? round($rusherStats->sum('AVG') / $numberOfGames, $round) : 0,
                    'TD' => $rusherStats->sum('TD') ? round($rusherStats->sum('TD') / $numberOfGames, $round) : 0,
                    'LONG' => $rusherStats->sum('LONG') ? round($rusherStats->sum('LONG') / $numberOfGames, $round) : 0,
                ]
            ]
        ];
        
        return $response;
    }
}

