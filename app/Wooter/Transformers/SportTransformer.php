<?php

namespace Wooter\Wooter\Transformers;

class SportTransformer extends Transformer
{
    public function transform($sport)
    {
        return [
            'id' => $sport->id,
            'name' => $sport->name,
            'name_localized' => $sport->name_localized,
        ];
    }
}