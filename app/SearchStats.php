<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class SearchStats extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'search_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'params',
        'created_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
