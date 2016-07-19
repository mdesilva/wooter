<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PlayerBasketballStat extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'player_basketball_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'game_id',
        'team_id',
        'jersey',
        'minutes_played',
        'points',
        'field_goals_made',
        'field_goals_attempted',
        '3_points_shots_made',
        '3_points_shots_attempted',
        'free_throws_made',
        'free_throws_attempted',
        'offensive_rebounds',
        'defensive_rebounds',
        'assists',
        'turnovers',
        'steals',
        'blocked_shots',
        'personal_fouls',
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function game() {
        return $this->belongsTo(Game::class);
    }
}
