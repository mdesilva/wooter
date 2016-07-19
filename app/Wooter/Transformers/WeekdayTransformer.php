<?php

namespace Wooter\Wooter\Transformers;

class WeekdayTransformer extends Transformer
{
    public function transform($weekday)
    {
        return [
            'id' => $weekday->id,
            'day' => $weekday->day,
            'day_localized' => $weekday->day_localized,
        ];
    }
}