<?php

namespace Wooter\Wooter\Exceptions\Player;

use Exception;

class PlayerConfirmPasswordIncorrectException extends Exception{
    protected $message = 'The new password provided and the confirmation password do not match, please insert them again.';
}