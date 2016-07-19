<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\CourtBooking;

class CourtBookingsRepository
{

    public function create(CourtBooking $booking)
    {
        return $booking->save();
    }

    public function update(CourtBooking $booking)
    {
        return $booking->save();
    }

    public function getById($booking_id)
    {
        return CourtBooking::whereId($booking_id)->first();
    }
}

