<?php
namespace Wooter\Wooter\Exceptions;

use Exception;

class SportNotFound extends Exception
{
    protected $message = 'The sport does not exist';
}