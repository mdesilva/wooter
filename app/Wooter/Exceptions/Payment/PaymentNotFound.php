<?php

namespace Wooter\Wooter\Exceptions\Payment;

use Exception;

class PaymentNotFound extends Exception{
    protected $message = 'The payment does not exist';
}