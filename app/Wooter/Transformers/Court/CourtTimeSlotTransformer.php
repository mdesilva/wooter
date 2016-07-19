<?php

namespace Wooter\Wooter\Transformers\Court;

use Wooter\Wooter\Transformers\Transformer;

class CourtTimeSlotTransformer extends Transformer
{
    public function transform($slot)
    {
        $slot = [
            'id' => $slot->id,
        ];
        
        return $slot;
    }
}

