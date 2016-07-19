<?php
namespace Wooter\Wooter\Transformers\Player;
use Wooter\Wooter\Transformers\Transformer;
class PlayerBasketballStatsTransformer extends Transformer
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
            'minutes' => 'TBA',
            'PTS' => 'TBA',
            '3FG' => 'TBA',
            '3FGA' => 'TBA',
            'AST' => 'TBA',
            'BLK' => 'TBA',
            'FG' => 'TBA',
            'FGA' => 'TBA',
            'FL' => 'TBA',
            'FT' => 'TBA',
            'FTA' => 'TBA',
            'STL' => 'TBA',
            'TURN' => 'TBA',
            'OFFRB' => 'TBA',
            'DEFRB' => 'TBA'
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
            'minutes' => $stats->minutes_played,
            'PTS' => $stats->points ? $stats->points : '0',
            '3FG' => $stats->{'3_points_shots_made'} ? $stats->{'3_points_shots_made'} : '0',
            '3FGA' => $stats->{'3_points_shots_attempted'} ? $stats->{'3_points_shots_attempted'} : '0',
            'AST' => $stats->assists ? $stats->assists : '0',
            'BLK' => $stats->blocked_shots ? $stats->blocked_shots : '0',
            'FG' => $stats->field_goals_made ? $stats->field_goals_made : '0',
            'FGA' => $stats->field_goals_attempted ? $stats->field_goals_attempted : '0',
            'FL' => $stats->personal_fouls ? $stats->personal_fouls : '0',
            'FT' => $stats->free_throws_made ? $stats->free_throws_made : '0',
            'FTA' => $stats->free_throws_attempted ? $stats->free_throws_attempted : '0',
            'STL' => $stats->steals ? $stats->steals : '0',
            'TURN' => $stats->turnovers ? $stats->turnovers : '0',
            'OFFRB' => $stats->offensive_rebounds ? $stats->offensive_rebounds : '0',
            'DEFRB' => $stats->defensive_rebounds ? $stats->defensive_rebounds : '0'
        ];
    }
}

