<?php
namespace Wooter\Wooter\Exceptions\Organization;

use Exception;

class OrganizationNotBelongToUser extends Exception{
    protected $message = 'You don\'t have access to this organization';
}