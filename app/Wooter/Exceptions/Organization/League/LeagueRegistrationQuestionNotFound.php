<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeagueRegistrationQuestionNotFound extends NotFoundException {
    protected $message = 'This league\'s registration question does not exist';
}