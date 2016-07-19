<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\Wooter\Exceptions\FileSystemException;

class LeagueVideo extends Model
{
    /**
     * folder for uploading video chunks
     */
    const TMP_FOLDER = 'temp/';
    /**
     * All user uploaded files
     */
    const UPLOAD_FOLDER = 'videos/';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'video_id',
        "label_id",
        "game_id"
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

    /**
     * The video
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }


    /**
     * league team videos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function team_videos()
    {
        return $this->belongsToMany(Team::class, "league_team_videos", "league_video_id", "team_id");
    }

    /**
     * league player videos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function player_videos()
    {
        return $this->belongsToMany(User::class, "league_player_videos", "league_video_id", "player_id");
    }

    /**
     * Boot function for the model
     */
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($leagueVideo) {

            if (file_exists($leagueVideo->video->file_path) && ! unlink($leagueVideo->video->file_path)) {
                throw new FileSystemException('There was an error when deleting the old video');
            }

            $leagueVideo->video->delete();
        });
    }

}
