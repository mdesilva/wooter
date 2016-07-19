<?php

namespace Wooter\Wooter\Transformers;

class PlayoffStructureTransformer extends Transformer
{
    public function transform($playoffStructure)
    {
        return [
            'id' => $playoffStructure->id,
            'name' => $playoffStructure->name,
            'name_localized' => $playoffStructure->name_localized,
        ];
    }
}