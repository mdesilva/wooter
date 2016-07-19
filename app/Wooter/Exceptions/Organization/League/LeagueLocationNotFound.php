<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueLocationNotFound extends NotFoundException {
    protected $message = 'The location of the league was not found';
}