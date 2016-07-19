<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerEmailAlreadyExistsException extends Exception{
    protected $message = 'A player with this email already exists, please select a different one.';
}