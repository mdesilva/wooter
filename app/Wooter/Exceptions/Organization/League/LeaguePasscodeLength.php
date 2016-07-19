<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguePasscodeLength extends NotFoundException
{
    protected $message = 'Passcode should not be less or greater than 6 characters!';
}