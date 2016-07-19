<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\GameVenueTransformer;
use Wooter\Wooter\Transformers\Transformer;

class LeagueGameVenueTransformer extends Transformer
{
    /**
     * @var GameVenueTransformer
     */
    private $gameVenueTransformer;

    /**
     * @param GameVenueTransformer $gameVenueTransformer
     */
    public function __construct(GameVenueTransformer $gameVenueTransformer) {

        $this->gameVenueTransformer = $gameVenueTransformer;
    }

    public function transform($leagueGameVenue) {
        $venue = [
            'id' => intval($leagueGameVenue->id),
            'league_id' => intval($leagueGameVenue->league_id),
            'game_venue' => $this->gameVenueTransformer->transform($leagueGameVenue->game_venue)
        ];
        
        return $venue;
    }
}
