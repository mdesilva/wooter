<?php

namespace Wooter\Wooter\Repositories\Follow;

use Wooter\FollowLeague;

class FollowLeagueRepository
{

    public function create(FollowLeague $followLeague)
    {
        return $followLeague->save();
    }

    public function update(FollowLeague $followLeague)
    {
        return $followLeague->save();
    }

    public function getById($followLeagueId)
    {
        return FollowLeague::whereId($followLeagueId)->first();
    }

    public function getByLeagueIdAndUserId($leagueId, $userId)
    {
        return FollowLeague::whereLeagueId($leagueId)->whereUserId($userId)->first();
    }

    public function getFollowingByUserId($userId)
    {
        return FollowLeague::whereUserId($userId)->whereStatus(FollowLeague::FOLLOWING)->get();
    }

}
