<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueNotBelongToUser extends NotFoundException {
    protected $message = 'You do not have access to this league';
}