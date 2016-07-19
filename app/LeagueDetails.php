<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeagueDetails extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'description',
        'number_of_teams',
        'players_per_team',
        'games_per_team',
        'max_players',
        'game_duration',
        'time_period',
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
}
