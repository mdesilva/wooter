<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguePhotoNotFound extends NotFoundException {
    protected $message = 'The league photo was not found';
}