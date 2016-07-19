<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PlayoffStructure extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'playoff_structures';

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
