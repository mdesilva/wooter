<?php

namespace Wooter\Wooter\Transformers\Court;

use Wooter\Wooter\Transformers\Transformer;

class CourtFeatureTransformer extends Transformer
{
    public function transform($features)
    {
        $features = [
            'id' => $features->id,
        ];
        
        return $features;
    }
}

