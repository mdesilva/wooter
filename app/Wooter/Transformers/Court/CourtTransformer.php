<?php

namespace Wooter\Wooter\Transformers\Court;

use Wooter\Wooter\Transformers\Transformer;

class CourtTransformer extends Transformer
{
    public function transform($court)
    {
        $court = [
            'name' => $court->name,
        ];
        
        return $court;
    }
}

