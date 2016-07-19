<?php

namespace Wooter\Wooter\Exceptions\Player;

use Wooter\Wooter\Exceptions\NotFoundException;

class PlayerAlreadyJoinedLeague extends NotFoundException
{
    protected $message = 'Player already joined the league';
}