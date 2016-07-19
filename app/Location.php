<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    const KILOMETERS = 'km';
    const MILES = 'mi';

    const BASE_DISTANCE = 10000;
    const DISTANCE_KILOMETERS = 6371;
    const DISTANCE_MILES = 3959;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'city_id',
        'state',
        'longitude',
        'latitude',
        'name',
        'street',
        'zip',
        'full_address',
        'flat',
    ];

    /**
     * The country of the location
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * The city of the location
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
