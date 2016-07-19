<?php

namespace Wooter\Wooter\Transformers;

class FeatureTransformer extends Transformer
{
    public function transform($feature)
    {
        return [
            'id' => $feature->id,
            'name' => $feature->name,
            'name_localized' => $feature->name_localized,
        ];
    }
}