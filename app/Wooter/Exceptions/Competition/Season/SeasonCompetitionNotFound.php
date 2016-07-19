<?php

namespace Wooter\Wooter\Exceptions\Competition\Season;

use Wooter\Wooter\Exceptions\NotFoundException;

class SeasonCompetitionNotFound extends NotFoundException {
    protected $message = 'This season was not found';
}