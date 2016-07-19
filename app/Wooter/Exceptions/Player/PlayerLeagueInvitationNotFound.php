<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerLeagueInvitationNotFound extends Exception{
    protected $message = 'No Invitation Found for the player!';
}