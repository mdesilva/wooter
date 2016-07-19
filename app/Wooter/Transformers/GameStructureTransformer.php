<?php

namespace Wooter\Wooter\Transformers;

class GameStructureTransformer extends Transformer
{
    public function transform($gameStructure)
    {
        return [
            'id' => $gameStructure->id,
            'name' => $gameStructure->name,
            'name_localized' => $gameStructure->name_localized,
        ];
    }
}