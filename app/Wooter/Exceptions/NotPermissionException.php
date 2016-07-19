<?php

namespace Wooter\Wooter\Exceptions;

use Exception;

class NotPermissionException extends Exception
{
    protected $message = 'You do not have permission to perform this action';
}