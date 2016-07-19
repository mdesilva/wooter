<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguePriceNotFound extends NotFoundException
{
    protected $message = 'The league price was not found';
}