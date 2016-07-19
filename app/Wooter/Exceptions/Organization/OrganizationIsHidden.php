<?php
namespace Wooter\Wooter\Exceptions\Organization;

use Exception;

class OrganizationIsHidden extends Exception{
    protected $message = 'This organization is publically hidden';
}