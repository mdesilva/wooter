<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class SoccerRules extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'soccer_rules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'times',
        'minutes_per_time',
        'points_per_win',
        'points_per_loss',
        'points_per_draw',
        'penalty_when_match_ends_in_draw',
        'max_red_cards_per_team_per_match',
        'max_yellow_cards_per_team_per_match',
    ];
}
