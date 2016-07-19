<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueBasicsNotFound extends NotFoundException {
    protected $message = 'The league basic information was not found';
}