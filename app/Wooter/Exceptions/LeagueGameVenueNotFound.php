<?php

namespace Wooter\Wooter\Exceptions;

class GameVenueNotFound extends NotFoundException {
    protected $message = 'The league game venue was not found';
}