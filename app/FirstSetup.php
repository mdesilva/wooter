<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class FirstSetup extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'first_setup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];
}
