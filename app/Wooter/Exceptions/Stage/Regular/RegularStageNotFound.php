<?php

namespace Wooter\Wooter\Exceptions\Stage\Regular;

use Wooter\Wooter\Exceptions\NotFoundException;

class RegularStageNotFound extends NotFoundException
{
    protected $message = 'The regular stage does not exists';
}