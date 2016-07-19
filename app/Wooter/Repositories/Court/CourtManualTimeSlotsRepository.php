<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\CourtManualTimeSlot;

class CourtManualTimeSlotsRepository
{

    public function create(CourtManualTimeSlot $slot)
    {
        return $slot->save();
    }

    public function update(CourtManualTimeSlot $slot)
    {
        return $slot->save();
    }

    public function getById($slot_id)
    {
        return CourtManualTimeSlot::whereId($slot_id)->first();
    }
}

