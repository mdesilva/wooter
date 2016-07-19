<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguePermissionPermissionLevelFound extends NotFoundException
{
    protected $message = 'The level of permission was not found';
}