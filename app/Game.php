<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\User;
use Wooter\LeagueSeason;
use Wooter\LeagueSeasonGameStats;
use Wooter\Team;

class Game extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'games';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stage_id',
        'stage_type',
        'home_team_id',
        'visiting_team_id',
        'home_team_score',
        'visiting_team_score',
        'game_venue_id',
        'sport_id',
        'time',
        'competition_week_id',
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'time',
    ];

    /**
     * @return array
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function stage()
    {
        return $this->morphTo();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitingTeam()
    {
        return $this->belongsTo(Team::class, 'visiting_team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game_venue()
    {
        return $this->belongsTo(GameVenue::class, 'game_venue_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function stats()
    {
        switch($this->sport->name) {
            case 'Basketball':
                $stats = $this->hasMany(TeamBasketballStat::class);
                break;
            case 'Softball':
                $stats = $this->hasMany(TeamSoftballStat::class);
                break;
            case 'Football':
                $stats = $this->hasMany(TeamFootballStat::class);
                break;
        }
        
        return $stats;
    }
    
    public function playerStats()
    {
        switch($this->sport->name) {
            case 'Basketball':
                $stats = $this->hasMany(PlayerBasketballStat::class);
                break;
            case 'Softball':
                //
                break;
            case 'Football':
                //
                break;
        }
        
        return $stats;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competition_week()
    {
        return $this->belongsTo(CompetitionWeek::class);
    }
}


