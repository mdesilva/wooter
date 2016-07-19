<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\PlayerSoftballBatterStat;
use Wooter\PlayerSoftballPitcherStat;

class TeamSoftballStatsAveragesTransformer extends Transformer
{
    public $type;

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
        
        $batterStats = PlayerSoftballBatterStat::whereIn('team_id', $uniqueTeamIds)->get();
        $pitcherStats = PlayerSoftballPitcherStat::whereIn('team_id', $uniqueTeamIds)->get();
        
        $round = 2;
        $response = [
            'first_inning_points' => round($stats->avg('first_inning_score'), $round),
            'second_inning_points' => round($stats->avg('second_inning_score'), $round),
            'third_inning_points' => round($stats->avg('third_inning_score'), $round),
            'fourth_inning_points' => round($stats->avg('fourth_inning_score'), $round),
            'fifth_inning_points' => round($stats->avg('fifth_inning_score'), $round),
            'sixth_inning_points' => round($stats->avg('sixth_inning_score'), $round),
            'seventh_inning_points' => round($stats->avg('seventh_inning_score'), $round),
            'eight_inning_points' => round($stats->avg('eight_inning_score'), $round),
            'ninth_inning_points' => round($stats->avg('ninth_inning_score'), $round),
            'points' => round($stats->avg('final_score'), $round),
            'wins' => round($stats->avg('win'), $round),
            'loss' => round($stats->avg('loss'), $round),
            'draw' => round($stats->avg('draw'), $round),
            'player_stats' => [
                'batters' => [
                    'AB' => $batterStats->sum('AB') ? round($batterStats->sum('AB') / $numberOfGames, $round) : 0,
                    'R' => $batterStats->sum('R') ? round($batterStats->sum('R') / $numberOfGames, $round) : 0,
                    'H' => $batterStats->sum('H') ? round($batterStats->sum('H') / $numberOfGames, $round) : 0,
                    'RBI' => $batterStats->sum('RBI') ? round($batterStats->sum('RBI') / $numberOfGames, $round) : 0,
                    'RBI' => $batterStats->sum('RBI') ? round($batterStats->sum('RBI') / $numberOfGames, $round) : 0,
                    'BB' => $batterStats->sum('BB') ? round($batterStats->sum('BB') / $numberOfGames, $round) : 0,
                    'SO' => $batterStats->sum('SO') ? round($batterStats->sum('SO') / $numberOfGames, $round) : 0,
                    'HBP' => $batterStats->sum('HBP') ? round($batterStats->sum('HBP') / $numberOfGames, $round) : 0,
                    'SF' => $batterStats->sum('SF') ? round($batterStats->sum('SF') / $numberOfGames, $round) : 0,
                    'TB' => $batterStats->sum('TB') ? round($batterStats->sum('TB') / $numberOfGames, $round) : 0,
                    'AVG' => $batterStats->sum('AVG') ? round($batterStats->sum('AVG') / $numberOfGames, $round) : 0,
                    'OBP' => $batterStats->sum('OBP') ? round($batterStats->sum('OBP') / $numberOfGames, $round) : 0,
                    'SLG' => $batterStats->sum('SLG') ? round($batterStats->sum('SLG') / $numberOfGames, $round) : 0,
                ],
                
                'pitchers' => [
                    'IP' => $pitcherStats->sum('IP') ? round($pitcherStats->sum('IP') / $numberOfGames, $round) : 0,
                    'H' => $pitcherStats->sum('H') ? round($pitcherStats->sum('H') / $numberOfGames, $round) : 0,
                    'R' => $pitcherStats->sum('R') ? round($pitcherStats->sum('R') / $numberOfGames, $round) : 0,
                    'ERR' => $pitcherStats->sum('ERR') ? round($pitcherStats->sum('ERR') / $numberOfGames, $round) : 0,
                    'BB' => $pitcherStats->sum('BB') ? round($pitcherStats->sum('BB') / $numberOfGames, $round) : 0,
                    'SO' => $pitcherStats->sum('SO') ? round($pitcherStats->sum('SO') / $numberOfGames, $round) : 0,
                    'HR' => $pitcherStats->sum('HR') ? round($pitcherStats->sum('HR') / $numberOfGames, $round) : 0,
                    'PC' => $pitcherStats->sum('PC') ? round($pitcherStats->sum('PC') / $numberOfGames, $round) : 0,
                    'ST' => $pitcherStats->sum('ST') ? round($pitcherStats->sum('ST') / $numberOfGames, $round) : 0,
                    'ERA' => $pitcherStats->sum('ERA') ? round($pitcherStats->sum('ERA') / $numberOfGames, $round) : 0,
                ]
            ]
        ];
        
        return $response;
    }
}

