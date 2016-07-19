<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PlayerStat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'player_stat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stat_id',
        'player_id',
    ];

    /**
     * The player the player stat belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    /**
     * The stat the player stat belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function stat()
    {
        return $this->belongsTo(Stat::class);
    }
}
