<?php
namespace Wooter\Wooter\Exceptions\User;

use Exception;

class UserIsNotAdmin extends Exception{
    protected $message = 'The user is not an admin. To pursue this action, the user must be an admin.';
}