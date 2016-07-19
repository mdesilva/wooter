<?php

namespace Wooter\Wooter\Exceptions;

class GameNotFound extends NotFoundException {
    protected $message = 'The game was not found';
}