<?php

namespace Wooter\Wooter\Repositories;

use Illuminate\Support\Facades\DB;
use Wooter\Weekday;

class WeekdayRepository
{

    public function create(Weekday $weekday)
    {
        return $weekday->save();
    }

    public function update(Weekday $weekday)
    {
        return $weekday->save();
    }

    public function getById($weekdayId) {
        return Weekday::whereId($weekdayId)->first();
    }

    public function search($params) {
        $query = DB::table('weekdays');

        if (isset($params['name']) && $params['name'] !== '') {
            $query->whereRaw('lower(weekdays.day) LIKE lower(?)', ['%'.$params['name'].'%']);
        }

        return $query->get();

    }

    public function getAll()
    {
        return Weekday::all();
    }
}
