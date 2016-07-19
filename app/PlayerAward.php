<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PlayerAward extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'player_awards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'award_id',
        'player_id',
    ];

    /**
     * The player the player award belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    /**
     * The award the player award belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function award()
    {
        return $this->belongsTo(Award::class);
    }
}
