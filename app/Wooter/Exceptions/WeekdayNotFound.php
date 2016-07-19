<?php
namespace Wooter\Wooter\Exceptions;

use Exception;

class WeekdayNotFound extends Exception
{
    protected $message = 'The weekday does not exist';
}