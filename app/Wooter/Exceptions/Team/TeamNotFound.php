<?php

namespace Wooter\Wooter\Exceptions\Team;

use Exception;

class TeamNotFound extends Exception{
    protected $message = 'Team not found';
}