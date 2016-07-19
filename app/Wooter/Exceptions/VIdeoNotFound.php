<?php
namespace Wooter\Wooter\Exceptions;

use Exception;

class VideoNotFound extends Exception
{
    protected $message = 'The video does not exist';
}