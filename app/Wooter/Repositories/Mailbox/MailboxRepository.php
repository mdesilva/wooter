<?php

namespace Wooter\Wooter\Repositories\Mailbox;

use DB;
use Wooter\Mailbox;

class MailboxRepository
{

    public function create(Mailbox $mailbox)
    {
        return $mailbox->save();
    }

    public function update(Mailbox $mailbox)
    {
        return $mailbox->save();
    }

    public function getById($mailboxId)
    {
        return Mailbox::whereId($mailboxId)->first();
    }
    
    public function getByUserId($userId)
    {
        return Mailbox::where('owner_id', '=', $userId)
                      ->where('owner_type', '=', 'WooterUser')
                      ->first();
    }
    
    public function getByLeagueId($leagueId)
    {
        return Mailbox::where('owner_id', '=', $leagueId)
                      ->where('owner_type', '=', 'WooterLeague')
                      ->first();
    }
    
    public function getByTeamId($teamId)
    {
        return Mailbox::where('owner_id', '=', $teamId)
                      ->where('owner_type', '=', 'WooterTeam')
                      ->first();
    }
    
    public function getByClubTypeAndClubId($club_type, $club_id, $user_id)
    {
        if ($club_type == 'league') {
            return $this->getByLeagueId($club_id);
        } else if ($club_type == 'team') {
            return $this->getByTeamId($club_id);
        } else {
            return $this->getByUserId($user_id);
        }
    }

}

