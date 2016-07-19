<?php

namespace Wooter\Wooter\Repositories\Player;

use DB;
use Auth;
use Wooter\Stat;

class StatRepository
{

    public function create(Stat $stat)
    {
        return $stat->save();
    }

    public function update(Stat $stat)
    {
        return $stat->save();
    }

    public function getById($statId) {
        return Stat::whereId($statId)->first();
    }

}
