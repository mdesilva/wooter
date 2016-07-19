<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerNotFound extends Exception{
    protected $message = 'Player not found';
}