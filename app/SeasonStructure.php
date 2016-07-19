<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class SeasonStructure extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'season_structures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_localized',
    ];
}
