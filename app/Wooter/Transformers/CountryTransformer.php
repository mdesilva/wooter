<?php

namespace Wooter\Wooter\Transformers;

class CountryTransformer extends Transformer
{
    public function transform($country)
    {
        return [
            'id' => $country->id,
            'name' => $country->name,
            'name_localized' => $country->name_localized,
        ];
    }
}