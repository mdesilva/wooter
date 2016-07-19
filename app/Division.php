<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'divisions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stage_id',
        'stage_type',
        'name',
    ];

    /**
     * The stage that the division belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stage()
    {
        return $this->morphTo();
    }

    /**
     * The teams that play in this division
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class,'team_division', 'division_id', 'team_id');
    }

}
