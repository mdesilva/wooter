<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;


class CourtManualLff extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'court_manual_off';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];
    
    /**
     * The owner of the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function court() {
        return $this->belongsTo(Court::class);
    }
    
}
