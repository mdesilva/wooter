<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class FacebookFriendship extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facebook_friendships';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_wooter_id',
        'user_facebook_id',
        'friend_facebook_id',
    ];


    /**
     * The organization that the league belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userWooter()
    {
        return $this->belongsTo(User::class, 'user_wooter_id', 'id');
    }
}
