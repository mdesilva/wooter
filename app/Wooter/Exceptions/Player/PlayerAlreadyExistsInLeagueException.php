<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerAlreadyExistsInLeagueException extends Exception{
    protected $message = 'The player already exists in this league';
}