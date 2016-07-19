<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;

class DivisionTransformer extends Transformer
{
    public function transform($division)
    {
        return [
            'id' => $division->id,
            'name' => $division->name,
            'stage_id' => $division->stage_id,
            'stage_type' => $division->stage_type,
        ];
    }
}