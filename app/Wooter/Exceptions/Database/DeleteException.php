<?php

namespace Wooter\Wooter\Exceptions\Organization\League;

use Wooter\Wooter\Exceptions\DatabaseException;

class DeleteException extends DatabaseException {
    protected $message = 'There was an error when deleting from the database';
}