<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguePasscodeAlreadyCreated extends NotFoundException
{
    protected $message = 'Passcode for the league is already created';
}