<?php

namespace Wooter\Wooter\Repositories\Player;

use DB;
use Auth;
use Wooter\PlayerAward;

class PlayerAwardRepository
{

    public function create(PlayerAward $playerAward)
    {
        return $playerAward->save();
    }

    public function update(PlayerAward $playerAward)
    {
        return $playerAward->save();
    }

    public function getById($playerAwardId) {
        return PlayerAward::whereId($playerAwardId)->first();
    }

    public function getAllByUserId($userId)
    {
        return PlayerAward::whereOrganizationId($userId)->get();
    }

}
