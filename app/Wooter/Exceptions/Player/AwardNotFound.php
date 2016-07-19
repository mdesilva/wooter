<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class AwardNotFound extends Exception{
    protected $message = 'Award not found';
}