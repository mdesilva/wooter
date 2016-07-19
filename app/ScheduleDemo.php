<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class ScheduleDemo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'schedule_demos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'comments'
    ];
}
