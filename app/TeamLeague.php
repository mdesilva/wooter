<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class TeamLeague extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'team_league';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'league_id',
    ];

    /**
     * The team
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * The league
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }
}

