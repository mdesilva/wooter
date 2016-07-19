<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const TYPE_BASIC_NOTIFICATION = 1;
    const TYPE_UPCOMING_GAME = 1;
    const TYPE_MATCH_SCORE_UPDATED = 2;
    const TYPE_TEAM_PAGE_UPDATED = 3;
    const TYPE_PROFILE_UPDATE_REQUIRED = 3;
    const TYPE_SYSTEM_UPDATED = 3;
    const TYPE_PLAYER_JOIN_LEAGUE = 3;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'text',
        'event_type',
        'consumed',
        'image_id',
        'user_id',
    ];

    /**
     * Returns the user that the notification belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the image that the notification belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
