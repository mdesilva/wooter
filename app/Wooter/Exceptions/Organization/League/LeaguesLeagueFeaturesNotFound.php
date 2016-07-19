<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\NotFoundException;

class LeaguesLeagueFeaturesNotFound extends NotFoundException {
    protected $message = 'This league\'s league feature does not exist';
}