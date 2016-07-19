<?php

namespace Wooter\Wooter\Repositories\Stage\Regular;

use Wooter\CompetitionWeek;
use Wooter\RegularStage;

class RegularCompetitionWeeksRepository
{

    public function create(CompetitionWeek $competitionWeek)
    {
        return $competitionWeek->save();
    }

    public function update(CompetitionWeek $competitionWeek)
    {
        return $competitionWeek->save();
    }

    public function getByRegularId($regularId) {
        return CompetitionWeek::whereStageId($regularId)->whereStageType(RegularStage::class)->get();
    }

    public function getById($competitionWeekId) {
        return CompetitionWeek::whereId($competitionWeekId)->whereStageType(RegularStage::class)->first();
    }
}