<?php
namespace Wooter\Wooter\Exceptions\StaticPages;

use Exception;

class PackageRequestNotFound extends Exception
{
    protected $message = 'The package request does not exist';
}