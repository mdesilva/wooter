<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeagueGameVenue extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_game_venues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'game_venue_id',
    ];

    /**
     * The league
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }

    /**
     * The game venue
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function game_venue()
    {
        return $this->belongsTo(GameVenue::class, 'game_venue_id');
    }
}
