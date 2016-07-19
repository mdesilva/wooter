<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class TeamDivision extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'team_division';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'division_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

}
