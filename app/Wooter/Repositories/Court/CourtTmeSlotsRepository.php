<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\CourtTimeSlot;

class CourtTimeSlotsRepository
{

    public function create(CourtTimeSlot $slot)
    {
        return $slot->save();
    }

    public function update(CourtTimeSlot $slot)
    {
        return $slot->save();
    }

    public function getById($slot_id)
    {
        return CourtTimeSlot::whereId($slot_id)->first();
    }
}

