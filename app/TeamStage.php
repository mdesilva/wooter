<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class TeamStage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'team_stage';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'stage_id',
        'stage_type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function stage()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
