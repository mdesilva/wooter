<?php
namespace Wooter\Wooter\Exceptions\StaticPages;

use Exception;

class ServiceRequestNotFound extends Exception
{
    protected $message = 'The service request does not exist';
}