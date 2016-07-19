<?php

namespace Wooter\Wooter\Exceptions\User;

use Exception;

class UserDeactivated extends Exception{
    protected $message = 'The user is Deactivated';
}