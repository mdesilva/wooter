<?php

namespace Wooter\Wooter\Exceptions\Payment;

use Exception;

class PaymentMethodNotFound extends Exception{
    protected $message = 'The payment method does not exist';
}