<?php

namespace Wooter\Wooter\Transformers\Court;

use Wooter\Wooter\Transformers\Transformer;

class CourtImageTransformer extends Transformer
{
    public function transform($image)
    {
        $image = [
            'id' => $image->id,
        ];
        
        return $image;
    }
}


