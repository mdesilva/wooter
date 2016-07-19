<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class RegularStage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'regular_stages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'competition_type',
        'rule_id',
        'rule_type',
        'starts_at',
        'ends_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function competition()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function weeks()
    {
        return $this->morphMany(CompetitionWeek::class, 'stage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisions()
    {
        return $this->morphMany(Division::class, 'stage');
    }
}
