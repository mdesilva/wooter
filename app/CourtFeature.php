<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;


class CourtFeature extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'court_features';

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


