<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class GameVenue extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'game_venues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'competition_type',
        'location_id',
        'court_name',
        'numbers_of_courts'
    ];

    /**
     * The competition of the game venue
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function competition()
    {
        return $this->morphTo();
    }

    /**
     * The location of the game venue
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
