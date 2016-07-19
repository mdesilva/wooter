<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\LeagueSeasonGame;

class LeagueSeasonGameStats extends Model {
    
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_season_game_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'game_id',
        'home_team_points',
        'visiting_team_points',
        'length'
    ];
    
    /**
     * The owner of the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function game() {
        return $this->belongsTo(LeagueSeasonGame::class);
    }

}

