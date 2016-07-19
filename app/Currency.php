<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const DOLLAR = 1;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_localized',
        'symbol'
    ];

    /**
     * The prices of the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function prices()
    {
        return $this->hasMany(LeaguePrice::class);
    }
}
