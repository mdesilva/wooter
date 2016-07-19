<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class SeasonCompetition extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'season_competitions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id',
        'organization_type',
        'name',
        'starts_at',
        'ends_at',
        'registration_opens_at',
        'registration_closes_at',
        'max_teams',
        'min_teams',
        'max_free_agents',
        'min_free_agents',
    ];

    /**
     * The league
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function regular_stages() {
        return $this->morphMany(RegularStage::class, 'competition');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function gameVenues() {
        return $this->morphMany(GameVenue::class, 'competition');
    }

}
