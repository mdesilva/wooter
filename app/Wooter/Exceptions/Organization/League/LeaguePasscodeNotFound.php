<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguePasscodeNotFound extends NotFoundException
{
    protected $message = 'Passcode for the league not found';
}