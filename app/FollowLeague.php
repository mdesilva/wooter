<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class FollowLeague extends Model
{
    const UNFOLLOWING = 0;
    const FOLLOWING = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'follow_leagues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'user_id',
        'status',
    ];

    /**
     * The league that the follow league model belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class);
    }

    /**
     * The user that the follow league model belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
