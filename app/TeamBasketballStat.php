<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class TeamBasketballStat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'team_basketball_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'team_id',
        'first_quarter_score',
        'second_quarter_score',
        'third_quarter_score',
        'fourth_quarter_score',
        'final_score',
        'win',
        'loss',
        'draw',
    ];

    /**
     * The game that the football stats belong to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    
    public function team() {
        return $this->belongsTo(Team::class);
    }
}
