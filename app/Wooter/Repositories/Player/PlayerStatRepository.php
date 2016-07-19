<?php

namespace Wooter\Wooter\Repositories\Player;

use DB;
use Auth;
use Wooter\PlayerStat;

class PlayerStatRepository
{

    public function create(PlayerStat $playerStat)
    {
        return $playerStat->save();
    }

    public function update(PlayerStat $playerStat)
    {
        return $playerStat->save();
    }

    public function getById($playerStatId) {
        return PlayerStat::whereId($playerStatId)->first();
    }

    public function getAllByUserId($userId)
    {
        return PlayerStat::whereOrganizationId($userId)->get();
    }

}
