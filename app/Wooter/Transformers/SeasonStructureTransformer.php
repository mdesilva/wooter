<?php

namespace Wooter\Wooter\Transformers;

class SeasonStructureTransformer extends Transformer
{
    public function transform($seasonStructure)
    {
        return [
            'id' => $seasonStructure->id,
            'name' => $seasonStructure->name,
            'name_localized' => $seasonStructure->name_localized,
        ];
    }
}