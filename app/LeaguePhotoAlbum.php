<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeaguePhotoAlbum extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_photo_albums';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'album_name',
        'league_id'
    ];


    /**
     * The league that the video belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }
}
