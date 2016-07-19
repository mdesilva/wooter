<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeaguePrice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'price',
        'description',
        'url',
    ];

    /**
     * The review that is belong to league
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }
}
