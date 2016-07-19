<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;

class PlayerSoftballPitcherStatsTransformer extends Transformer
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
            'IP' => $stats->IP ? $stats->IP : '0',
            'H' => $stats->H ? $stats->H : '0',
            'R' => $stats->R ? $stats->R : '0',
            'ERR' => $stats->ERR ? $stats->ERR : '0',
            'BB' => $stats->BB ? $stats->BB : '0',
            'SO' => $stats->SO ? $stats->SO : '0',
            'HR' => $stats->HR ? $stats->HR : '0',
            'PC' => $stats->PC ? $stats->PC : '0',
            'ST' => $stats->ST ? $stats->ST : '0',
            'ERA' => $stats->ERA ? round($stats->ERA, 2) : '0'
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
            'IP' => 'TBA',
            'H' => 'TBA',
            'R' => 'TBA',
            'ERR' => 'TBA',
            'BB' => 'TBA',
            'SO' => 'TBA',
            'HR' => 'TBA',
            'PC' => 'TBA',
            'ST' => 'TBA',
            'ERA' => 'TBA'
        ];
    }
}

