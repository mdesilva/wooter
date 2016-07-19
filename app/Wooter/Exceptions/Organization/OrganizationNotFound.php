<?php
namespace Wooter\Wooter\Exceptions\Organization;

use Exception;

class OrganizationNotFound extends Exception{
    protected $message = 'The organization does not exist';
}