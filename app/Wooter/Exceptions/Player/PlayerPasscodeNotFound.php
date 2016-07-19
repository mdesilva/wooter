<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerPasscodeNotFound extends Exception
{
    protected $message = 'Join league passcode incorrect';
}