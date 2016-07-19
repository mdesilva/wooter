<?php

namespace Wooter\Wooter\Transformers\Stage\Regular;

use Wooter\RegularStage;
use Wooter\Wooter\Transformers\Transformer;

class RegularStagesTransformer extends Transformer
{
    public function transform($stage)
    {
        $stage = [
            'id' => $stage->id,
            'type' => RegularStage::class,
            'competition_id' => $stage->competition_id,
            'competition_type' => $stage->competition_type,
            'rule_id' => $stage->rule_id,
            'rule_type' => $stage->rule_type,
            'starts_at' => $stage->starts_at,
            'ends_at' => $stage->ends_at
        ];
            
        return $stage;
    }
}

