<?php

namespace Wooter\Wooter\Exceptions\Team;

use Exception;

class TeamAlreadyJoinedLeague extends Exception{
    protected $message = 'Team already joined this league';
}