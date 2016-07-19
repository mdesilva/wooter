<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'awards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
    ];
}
