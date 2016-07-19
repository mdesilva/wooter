<?php

namespace Wooter\Wooter\Transformers\Court;

use Wooter\Wooter\Transformers\Transformer;

class CourtManualOffTransformer extends Transformer
{
    public function transform($off)
    {
        $off = [
            'id' => $off->id,
        ];
        
        return $off;
    }
}

