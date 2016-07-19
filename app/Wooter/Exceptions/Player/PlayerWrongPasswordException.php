<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerWrongPasswordException extends Exception{
    protected $message = 'The password is incorrect for this player.';
}