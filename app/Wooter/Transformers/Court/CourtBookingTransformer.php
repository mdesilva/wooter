<?php

namespace Wooter\Wooter\Transformers\Court;

use Wooter\Wooter\Transformers\Transformer;

class CourtBookingTransformer extends Transformer
{
    public function transform($court)
    {
        $court = [
            'id' => $court->id,
        ];
        
        return $court;
    }
}
