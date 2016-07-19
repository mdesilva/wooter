<?php
namespace Wooter\Wooter\Exceptions;

use Exception;

class SlugExistsException extends Exception
{
    protected $message = 'This slug already exists';
}