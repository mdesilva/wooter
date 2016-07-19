<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    const TYPE_VIDEO = 1;
    const TYPE_STATS = 2;
    const TYPE_REFEREE = 3;

    public static $types = [
        self::TYPE_VIDEO => 'Video',
        self::TYPE_STATS => 'Stats',
        self::TYPE_REFEREE => 'Referee',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'service_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'name',
        'phone',
        'sport',
        'type',
        'address_1',
        'address_2',
        'number_of_players',
        'number_of_teams',
        'number_of_games_per_team',
    ];
}
