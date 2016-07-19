<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class TeamFootballStat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'team_football_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'team_id',
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
}
