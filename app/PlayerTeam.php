<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PlayerTeam extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'player_team';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'team_id',
        'stage_id',
        'stage_type',
    ];

    protected  $dates = [
        'created_at',
        'updated_at',
        'joined_at',
    ];

    /**
     * @return array
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * The player the player-team relation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    /**
     * The team the player-team relation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function stage()
    {
        return $this->morphTo();
    }
    
    public function positions() 
    {
        return $this->hasMany(PlayerPosition::class, 'player_team_id');
    }

}
