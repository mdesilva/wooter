<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerLeagueNotFound extends Exception{
    protected $message = 'Player league not found';
}