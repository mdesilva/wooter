<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeagueFeature extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_features';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'feature_id',
    ];

    /**
     * The league that the details information belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }

    /**
     * The league that the details information belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
