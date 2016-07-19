<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    const SOCCER = 1;
    const BASKETBALL = 2;
    const HOCKEY = 3;
    const FOOTBALL = 4;
    const TENNIS = 5;
    const BASEBALL = 6;
    const KICKBALL = 7;
    const SOFTBALL = 8;
    const BOWLING = 9;
    const DODGEBALL = 10;
    const VOLLEYBALL = 11;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_localized',
    ];
}
