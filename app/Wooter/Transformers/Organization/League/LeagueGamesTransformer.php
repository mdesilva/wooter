<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Game\GamesTransformer;
use Wooter\Wooter\Transformers\Transformer;

class LeagueGamesTransformer extends Transformer
{
    public $playerId;
    private $gamesTransformer;

    /**
     * @param GamesTransformer $gamesTransformer
     */
    public function __construct(GamesTransformer $gamesTransformer)
    {

        $this->gamesTransformer = $gamesTransformer;
    }
    
    public function transform($game)
    {
        $result = $this->gamesTransformer->transform($game);
        
        if ($this->playerId) {
            $playerStats = $game->playerStats()->where('player_id', $this->playerId)->first();
            $result['player_stats'] = $playerStats ? $playerStats->toArray() : null;
        }
        
       return $result;
    }
}
