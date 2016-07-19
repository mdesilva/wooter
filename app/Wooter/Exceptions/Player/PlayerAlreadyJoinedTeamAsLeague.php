<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerAlreadyJoinedTeamAsLeague extends Exception{
    protected $message = 'Player has been already added to league with a team';
}