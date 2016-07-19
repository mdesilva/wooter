<?php

namespace Wooter\Wooter\Exceptions;

use Exception;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class NotFoundException extends Exception
{
    protected $message = 'Not Found';

    protected $code = HTTPStatusCode::NOT_FOUND;
}