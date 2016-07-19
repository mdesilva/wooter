<?php

namespace Wooter\Wooter\Transformers\Court;

use Wooter\Wooter\Transformers\Transformer;

class CourtPriceTransformer extends Transformer
{
    public function transform($price)
    {
        $price = [
            'id' => $price->id,
        ];
        
        return $price;
    }
}

