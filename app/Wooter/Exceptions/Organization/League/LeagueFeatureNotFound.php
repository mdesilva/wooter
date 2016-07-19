<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueFeatureNotFound extends NotFoundException {
    protected $message = 'This league\'s feature does not exist';
}