<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeagueReview extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reviewer_id',
        'league_id',
        'review',
        'stars',
        'verified',
    ];

    /**
     * The review that is belong to league
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }

    /**
     * The user reviewing the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
