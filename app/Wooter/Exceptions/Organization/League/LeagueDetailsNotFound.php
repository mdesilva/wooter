<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueDetailsNotFound extends NotFoundException {
    protected $message = 'The details of this league were not found';
}