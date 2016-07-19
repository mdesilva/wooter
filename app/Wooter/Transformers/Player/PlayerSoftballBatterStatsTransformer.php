<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;

class PlayerSoftballBatterStatsTransformer extends Transformer
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
            'game_id' => $stats->game_id,
            'name' => $stats->name,
            'jersey' => $stats->jersey,
            'active' => $stats->active,
            'activate' => 0,
            'deactivate' => 0,
            'AB' => $stats->AB ? $stats->AB : '0',
            'R' => $stats->R ? $stats->R : '0',
            'H' => $stats->H ? $stats->H : '0',
            'RBI' => $stats->RBI ? $stats->RBI : '0',
            'BB' => $stats->BB ? $stats->BB : '0',
            'SO' => $stats->SO ? $stats->SO : '0',
            'HBP' => $stats->HBP ? $stats->HBP : '0',
            'SF' => $stats->SF ? $stats->SF : '0',
            'TB' => $stats->TB ? $stats->TB : '0',
            'AVG' => $stats->AVG ? round($stats->AVG, 1) : '0',
            'OBP' => $stats->OBP ? round($stats->OBP, 2) : '0',
            'SLG' => $stats->SLG ? round($stats->SLG, 2) : '0'
        ];
    }
    
    private function getScoredGameStats($stats) {
        return [
            'id' => $stats->id,
            'player_id' => $stats->player_id,
            'team_id' => $stats->team_id,
            'game_id' => $stats->game_id,
            'name' => $stats->name,
            'jersey' => $stats->jersey,
            'active' => $stats->active,
            'activate' => 0,
            'deactivate' => 0,
            'AB' => 'TBA',
            'R' => 'TBA',
            'H' => 'TBA',
            'RBI' => 'TBA',
            'BB' => 'TBA',
            'SO' => 'TBA',
            'HBP' => 'TBA',
            'SF' => 'TBA',
            'TB' => 'TBA',
            'AVG' => 'TBA',
            'OBP' => 'TBA',
            'SLG' => 'TBA'
        ];
    }
}


