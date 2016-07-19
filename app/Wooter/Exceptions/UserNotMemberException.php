<?php

namespace Wooter\Wooter\Exceptions;

use Exception;

class UserNotMemberException extends Exception
{
    protected $message = 'User is not a member of the league, can not perform this action. Must be member.';
}