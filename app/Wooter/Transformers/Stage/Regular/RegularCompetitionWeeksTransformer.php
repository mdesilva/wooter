<?php

namespace Wooter\Wooter\Transformers\Stage\Regular;

use Wooter\Wooter\Transformers\Transformer;

class RegularCompetitionWeeksTransformer extends Transformer
{
    
    public function transform($week)
    {
        $week = [
            'id' => $week->id,
            'regular_id' => $week->stage_id,
            'name' => $week->name,
            'starts_at' => $week->starts_at,
            'ends_at' => $week->ends_at
        ];
        
        return $week;
    }
}
