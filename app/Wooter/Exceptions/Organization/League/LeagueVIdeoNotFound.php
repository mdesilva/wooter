<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueVideoNotFound extends NotFoundException {
    protected $message = 'This league\'s video was not found';
}