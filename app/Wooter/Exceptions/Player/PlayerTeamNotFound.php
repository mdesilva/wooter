<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerTeamNotFound extends Exception{
    protected $message = 'Player team not found';
}