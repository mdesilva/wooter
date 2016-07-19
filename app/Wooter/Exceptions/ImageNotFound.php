<?php
namespace Wooter\Wooter\Exceptions;

use Exception;

class ImageNotFound extends Exception
{
    protected $message = 'The image does not exist';
}