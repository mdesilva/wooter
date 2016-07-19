<?php

namespace Wooter\Wooter\Repositories;

use Wooter\GameVenue;

class GameVenueRepository
{
    public function create(GameVenue $gameVenue)
    {
        return $gameVenue->push();
    }

    public function update(GameVenue $gameVenue)
    {
        return $gameVenue->push();
    }

    public function getById($gameVenueId) {
        return GameVenue::whereId($gameVenueId)->with('location')->first();
    }

    public function getByLeagueIdWithPagination($leagueId, $limit)
    {
        return GameVenue::whereLeagueId($leagueId)->paginate($limit);
    }
    
    public function deleteById($gameVenueId) {
        return GameVenue::whereId($gameVenueId)->delete();
    }
}