<?php

namespace Wooter\Wooter\Repositories;

use Carbon\Carbon;
use DB;
use Wooter\CompetitionWeek;

class CompetitionWeeksRepository
{

    public function create(CompetitionWeek $week)
    {
        return $week->push();
    }

    public function update(CompetitionWeek $week)
    {
        return $week->push();
    }

    public function getById($weekId) {
        return CompetitionWeek::whereId($weekId)->first();
    }

    public function getByStageAndDates($stageId, $stageType, Carbon $startsAt, Carbon $endsAt)
    {
        return CompetitionWeek::whereStageType($stageType)
            ->whereStageId($stageId)
            ->whereDate('starts_at', '>=', $startsAt->toDateString())
            ->whereDate('ends_at', '<=', $endsAt->toDateString())
            ->first();
    }

    /**
     * @param        $date
     * @param        $stageId
     * @param        $stageType
     *
     * @return mixed
     */
    public function getCompetitionWeekId($date, $stageId, $stageType)
    {
        $startOfWeek = (new Carbon($date))->startOfWeek();
        $endOfWeek = (new Carbon($date))->endOfWeek();

        $competitionWeek = $this->getByStageAndDates($stageId, $stageType, $startOfWeek, $endOfWeek);

        if ( ! $competitionWeek) {
            $competitionWeek = new CompetitionWeek;
            $competitionWeek->stage_id = $stageId;
            $competitionWeek->stage_type = $stageType;
            $competitionWeek->starts_at = $startOfWeek;
            $competitionWeek->ends_at = $endOfWeek;
            $this->create($competitionWeek);
        }

        return $competitionWeek->id;
    }
}


