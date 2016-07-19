<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeagueLocation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'location_id',
    ];

    /**
     * The league that the location belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }

    /**
     * The location itself
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
