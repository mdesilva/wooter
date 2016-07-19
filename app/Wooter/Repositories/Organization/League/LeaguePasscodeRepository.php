<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeaguePasscode;

class LeaguePasscodeRepository
{


    public function create(LeaguePasscode $leaguePasscode)
    {
        return $leaguePasscode->save();
    }

    public function getById($id)
    {

        return LeaguePasscode::whereId($id)->first();
    }

    public function getPasscodeFromId($leagueId) {


        return LeaguePasscode::select('passcode','id')->whereLeagueId($leagueId)->first();
    }



}
