<?php

namespace Wooter\Wooter\Repositories\Player;

use DB;
use Auth;
use Wooter\Award;

class AwardRepository
{

    public function create(Award $award)
    {
        return $award->save();
    }

    public function update(Award $award)
    {
        return $award->save();
    }

    public function getById($awardId) {
        return Award::whereId($awardId)->first();
    }

}
