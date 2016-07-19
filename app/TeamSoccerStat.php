<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class TeamSoccerStat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'team_soccer_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'team_id',
        'red_cards',
        'yellow_cards',
        'goals',
        'faults',
        'penalties',
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
