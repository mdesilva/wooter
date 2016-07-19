<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\CourtManualOff;

class CourtManualOffRepository
{

    public function create(CourtManuslOff $off)
    {
        return $off->save();
    }

    public function update(CourtManualOff $off)
    {
        return $off->save();
    }

    public function getById($off_id)
    {
        return CourtManualOff::whereId($off_id)->first();
    }
}

