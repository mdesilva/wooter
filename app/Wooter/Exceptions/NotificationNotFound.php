<?php
namespace Wooter\Wooter\Exceptions;

use Exception;

class NotificationNotFound extends Exception
{
    protected $message = 'The notification does not exist';
}