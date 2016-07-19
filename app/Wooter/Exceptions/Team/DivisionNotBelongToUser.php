<?php

namespace Wooter\Wooter\Exceptions\Team;

use Exception;

class DivisionNotBelongToUser extends Exception{
    protected $message = 'You do not have access to this division';
}