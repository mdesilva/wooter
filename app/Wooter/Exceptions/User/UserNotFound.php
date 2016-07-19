<?php
namespace Wooter\Wooter\Exceptions\User;

use Exception;

class UserNotFound extends Exception{
    protected $message = 'The user does not exist';
}