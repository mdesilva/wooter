<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class CompetitionWeek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'competition_weeks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'starts_at',
        'ends_at',
        'name',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'starts_at',
        'ends_at',
    ];

    public function getDates()
    {
        return $this->dates;
    }

    public function stage() {
        return $this->morphTo();
    }
}