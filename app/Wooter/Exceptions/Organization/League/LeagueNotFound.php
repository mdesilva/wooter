<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueNotFound extends NotFoundException
{
    protected $message = 'This league does not exist';
}