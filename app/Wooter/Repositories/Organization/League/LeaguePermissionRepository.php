<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use Wooter\LeaguePermission;

class LeaguePermissionRepository
{

    public function create(LeaguePermission $leaguePermission)
    {
        return $leaguePermission->push();
    }

    public function update(LeaguePermission $leaguePermission)
    {
        return $leaguePermission->push();
    }

    public function getById($leaguePermissionId) {
        return LeaguePermission::whereId($leaguePermissionId)->first();
    }

    public function getByLeagueId($leagueId)
    {
        return LeaguePermission::whereLeagueId($leagueId)->get();
    }

    public function getByLeagueIdAndType($leagueId, $type)
    {
        return LeaguePermission::whereLeagueId($leagueId)->whereType($type)->first();
    }

}
