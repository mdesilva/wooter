<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class BasketballRules extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'basketball_rules';

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
    ];
}
