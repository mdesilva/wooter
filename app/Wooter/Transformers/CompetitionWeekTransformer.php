<?php

namespace Wooter\Wooter\Transformers;

use Carbon\Carbon;
use Wooter\CompetitionWeek;

class CompetitionWeekTransformer extends Transformer
{
    /**
     * @param $competitionWeek
     *
     * @return array
     */
    public function transform($competitionWeek)
    {

        return [
            'id' => $competitionWeek->id,
            'stage_id' => $competitionWeek->stage_id,
            'stage_type' => $competitionWeek->stage_type,
            'starts_at' => $competitionWeek->starts_at,
            'ends_at' => $competitionWeek->ends_at,
            'name' => $competitionWeek->name,
            'week_of_year' => $competitionWeek->starts_at->weekOfYear,
            'start_day' => $competitionWeek->starts_at->day,
            'start_month' => $competitionWeek->starts_at->month,
            'end_day' => $competitionWeek->ends_at->day,
            'end_month' => $competitionWeek->ends_at->month,
        ];
    }
}