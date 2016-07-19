<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class SportPosition extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sport_positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //
    ];
    
    public function sport() {
        return $this->belongsTo(Sport::class, 'sport_id');
    }
    
}

