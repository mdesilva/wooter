<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Weekday extends Model
{
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;

    protected $table = 'weekdays';

    protected $fillable = ['day','day_localized'];
}
