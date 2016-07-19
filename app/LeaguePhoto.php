<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\Wooter\Exceptions\FileSystemException;

class LeaguePhoto extends Model
{
    const IMAGE_PREFIX = 'league_photo_';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'image_id'
    ];

    /**
     * The league that the photo belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }

    /**
     * The photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function photo()
    {

        return $this->belongsTo(Image::class, 'image_id');
    }


    /**
     * league team photos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function team_photos()
    {
        return $this->belongsToMany(Team::class, "league_team_photos", "league_photo_id", "team_id");
    }

    /**
     * league player photos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function player_photos()
    {
        return $this->belongsToMany(User::class, "league_player_photos", "league_photo_id", "player_id");
    }

    /**
     * Boot function for the model
     */
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($leaguePhoto) {

            if (file_exists($leaguePhoto->photo->file_path) && ! unlink($leaguePhoto->photo->file_path)) {
                throw new FileSystemException('There was an error when deleting the old photo');
            }


            if (file_exists($leaguePhoto->photo->thumbnail_path) && ! unlink($leaguePhoto->photo->thumbnail_path)) {
                throw new FileSystemException('There was an error when deleting the old photo thumbnail');
            }

            $leaguePhoto->photo->delete();
        });
    }
}
