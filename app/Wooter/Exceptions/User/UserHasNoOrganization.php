<?php

namespace Wooter\Wooter\Exceptions\User;

use Exception;

class UserHasNoOrganization extends Exception{
    protected $message = 'The user has not an organization';
}