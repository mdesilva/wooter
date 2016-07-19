<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PlayerFootballDefenderStat extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'player_football_defender_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];

    /**
     * The player that the stats belong to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function player() {
        return $this->belongsTo(User::class, 'player_id');
    }
    
    /**
     * The team that the stats belong to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function team() {
        return $this->belongsTo(Team::class);
    }
    
    /**
     * The game that the stats belong to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function game() {
        return $this->belongsTo(LeagueSeasonGame::class);
    }
}

