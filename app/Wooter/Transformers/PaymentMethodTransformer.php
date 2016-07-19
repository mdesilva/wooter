<?php

namespace Wooter\Wooter\Transformers;

class PaymentMethodTransformer extends Transformer
{
    public function transform($paymentMethod)
    {
        return [
            'id' => $paymentMethod->id,
            'name' => $paymentMethod->name,
        ];
    }
}