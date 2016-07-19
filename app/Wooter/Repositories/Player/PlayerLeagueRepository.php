<?php

namespace Wooter\Wooter\Repositories\Player;

use DB;
use Auth;
use Wooter\PlayerLeague;

class PlayerLeagueRepository
{
    public function create(PlayerLeague $playerLeague)
    {
        return $playerLeague->save();
    }
    public function update(PlayerLeague $playerLeague)
    {
        return $playerLeague->save();
    }
    public function getById($playerLeagueId) {
        return PlayerLeague::whereId($playerLeagueId)->first();
    }
    public function getAllByUserId($userId)
    {
        return PlayerLeague::whereOrganizationId($userId)->get();
    }

    public function getByPlayerAndLeagueId($playerId, $leagueId)
    {
        return PlayerLeague::wherePlayerId($playerId)->whereLeagueId($leagueId)->first();
    }
}