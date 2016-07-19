<?php

namespace Wooter\Wooter\Repositories\Stage\Regular;

use Wooter\RegularStage;

class RegularStageRepository
{

    public function create(RegularStage $stage)
    {
        return $stage->save();
    }

    public function update(RegularStage $stage)
    {
        return $stage->save();
    }

    public function getById($stageId) {
        return RegularStage::whereId($stageId)->first();
    }
}