<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeagueVideoLabelTransformer extends Transformer
{
    public function transform($label)
    {


        return [
            'id' => $label->id,
            'name' => $label->label_name

        ];

    }
}