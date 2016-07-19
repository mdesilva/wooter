<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerAwardNotFound extends Exception{
    protected $message = 'Player award not found';
}