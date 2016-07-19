<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerStatNotFound extends Exception{
    protected $message = 'Player stat not found';
}