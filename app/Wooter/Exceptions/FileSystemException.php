<?php
namespace Wooter\Wooter\Exceptions;

use Exception;

class FileSystemException extends Exception
{
    protected $message = 'There was an error with the file system';
}