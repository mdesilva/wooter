<?php

namespace Wooter\Wooter\Exceptions\User;

use Exception;

class UserHasNoLeagues extends Exception{
    protected $message = 'The user has not any leagues';
}