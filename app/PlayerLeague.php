<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PlayerLeague extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'player_league';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'league_id',
    ];

    /**
     * The player the player-team relation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    /**
     * The team the player-team relation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class);
    }

}
