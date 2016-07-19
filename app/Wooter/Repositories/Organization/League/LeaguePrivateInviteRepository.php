<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeaguePasscode;
use Wooter\LeaguePrivateInvite;

class LeaguePrivateInviteRepository
{
    /**
     * @param LeaguePrivateInvite $leaguePrivateInvite
     *
     * @return bool
     */
    public function create(LeaguePrivateInvite $leaguePrivateInvite)
    {
        return $leaguePrivateInvite->push();
    }

    /**
     * @param LeaguePrivateInvite $leaguePrivateInvite
     *
     * @return bool
     */
    public function update(LeaguePrivateInvite $leaguePrivateInvite)
    {
        return $leaguePrivateInvite->push();
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getInvited($email) {
         return LeaguePrivateInvite::whereEmail($email)->first();
    }

    /**
     * @param $email
     * @param $token
     *
     * @return mixed
     */
    public function checkJoinStatus($email, $token) {
        return LeaguePrivateInvite::whereEmail($email)->whereToken($token)->first();
    }
}
