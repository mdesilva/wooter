<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;

class AwardTransformer extends Transformer
{
    public function transform($award)
    {
        return [
            'id' => $award->id,
            'name' => $award->name,
        ];
    }
}