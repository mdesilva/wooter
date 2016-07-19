<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class StatNotFound extends Exception{
    protected $message = 'Stat not found';
}