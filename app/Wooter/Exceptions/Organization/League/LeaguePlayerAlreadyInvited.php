<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguePlayerAlreadyInvited extends NotFoundException
{
    protected $message = 'This player is already invited';
}