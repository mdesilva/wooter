<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguePermissionTypeNotFound extends NotFoundException
{
    protected $message = 'The league permission type was not found';
}