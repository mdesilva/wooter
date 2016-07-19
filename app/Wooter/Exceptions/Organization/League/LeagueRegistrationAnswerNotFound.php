<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueRegistrationAnswerNotFound extends NotFoundException {
    protected $message = 'This league\'s registration answer was not found';
}