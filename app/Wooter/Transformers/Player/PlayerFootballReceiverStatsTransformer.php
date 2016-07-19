<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;

class PlayerFootballReceiverStatsTransformer extends Transformer
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
            'REC' => $stats->REC ? $stats->REC : '0',
            'YDS' => $stats->YDS ? $stats->YDS : '0',
            'AVG' => $stats->AVG ? round($stats->AVG, 1) : '0',
            'TD' => $stats->TD ? $stats->TD : '0',
            'LONG' => $stats->LONG ? $stats->LONG : '0',
            'TGTS' => $stats->TGTS ? $stats->TGTS : '0'
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
            'REC' => 'TBA',
            'YDS' => 'TBA',
            'AVG' => 'TBA',
            'TD' => 'TBA',
            'LONG' => 'TBA',
            'TGTS' => 'TBA'
        ];
    }
}
