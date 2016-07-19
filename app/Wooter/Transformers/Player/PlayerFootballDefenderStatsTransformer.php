<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;

class PlayerFootballDefenderStatsTransformer extends Transformer
{
    public $verbose;
    
    public function transform($stats)
    {
        $gameId = $stats->game->id;
        $homeTeamStats = $stats->game->homeTeam->stats()->where('game_id', $gameId)->first();
        $gameStatus = $homeTeamStats->win + $homeTeamStats->loss + $homeTeamStats->draw;
        
        switch ($this->verbose) {
            case 'true':
                switch ($gameStatus) {
                    case 0:
                        $response = $this->getNonScoredGameStats($stats);
                        break;
                    case 1:
                        $response = $this->getScoredGameStats($stats);
                        break;
                }
                break;
            case 'false':
                $response = $this->getScoredGameStats($stats);
                break;
        }
        
        return $response;
    }
    
    private function getNonScoredGameStats($stats) {
        return [
            'id' => $stats->id,
            'player_id' => $stats->player_id,
            'team_id' => $stats->team_id,
            'name' => $stats->name,
            'jersey' => $stats->jersey,
            'active' => $stats->active,
            'activate' => 0,
            'deactivate' => 0,
            'INT' => $stats->INT ? $stats->INT : '0',
            'YDS' => $stats->YDS ? $stats->YDS : '0',
            'TKLS' => $stats->TKLS ? $stats->TKLS : '0',
            'SACKS' => $stats->SACKS ? $stats->SACKS : '0',
            'TD' => $stats->TD ? $stats->TD : '0'
        ];
    }
    
    private function getScoredGameStats($stats) {
        return [
            'id' => $stats->id,
            'player_id' => $stats->player_id,
            'team_id' => $stats->team_id,
            'name' => $stats->name,
            'jersey' => $stats->jersey,
            'active' => $stats->active,
            'activate' => 0,
            'deactivate' => 0,
            'INT' => 'TBA',
            'YDS' => 'TBA',
            'TKLS' => 'TBA',
            'SACKS' => 'TBA',
            'TD' => 'TBA'
        ];
    }
}

