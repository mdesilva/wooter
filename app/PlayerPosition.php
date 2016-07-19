<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PlayerPosition extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'player_position';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //
    ];
    
    public function playerTeam() {
        return $this->belongsTo(PlayerTeam::class, 'player_team_id');
    }
    
    public function position() {
        return $this->belongsTo(SportPosition::class, 'position_id');
    }
}

