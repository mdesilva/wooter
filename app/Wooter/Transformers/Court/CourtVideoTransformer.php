<?php

namespace Wooter\Wooter\Transformers\Court;

use Wooter\Wooter\Transformers\Transformer;

class CourtVideoTransformer extends Transformer
{
    public function transform($video)
    {
        $video = [
            'id' => $video->id,
        ];
        
        return $video;
    }
}

