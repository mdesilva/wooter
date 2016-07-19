<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;


class CourtOrganization extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'court_organizations';

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
    public function bookings() {
        return $this->hasMany(CourtBooking::class);
    }
    
    /**
     * The conversations that belong to the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function features() {
        return $this->hasOne(CourtFeature::class);
    }
    
    /**
     * The broadcasts that belong to the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function image() {
        return $this->hasOne(CourtImage::class);
    }
    
    public function manualOff() {
        return $this->hasOne(CourtManualOff::class);
    }
    
    public function manualTimeSlot() {
        return $this->hasOne(CourtManualTimeSlot::class);
    }
    
    public function timeSlot() {
        return $this->hasOne(CourtTimeSlot::class);
    }
    
    public function price() {
        return $this->hasOne(CourtPrice::class);
    }
    
    public function videos() {
        return $this->hasMany(CourtVideo::class);
    }
}



