<?php

namespace Wooter\Wooter\Exceptions\Stage\Regular;

use Wooter\Wooter\Exceptions\NotFoundException;

class RegularCompetitionWeekNotFound extends NotFoundException
{
    protected $message = 'The regular competition week does not exists';
}