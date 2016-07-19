<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\Wooter\Exceptions\FileSystemException;

class LeagueBasics extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_basics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'logo_id',
        'gender',
        'min_age',
        'max_age',
    ];

    /**
     * The league that the basic information belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }

    /**
     * The logo of the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function logo()
    {
        return $this->belongsTo(Image::class, 'logo_id');
    }

    /**
     * Boot function for the model
     */
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($leagueBasics) {

            if (file_exists($leagueBasics->logo->file_path) && ! unlink($leagueBasics->logo->file_path)) {
                throw new FileSystemException('There was an error when deleting the old logo');
            }

            if (file_exists($leagueBasics->logo->thumbnail_path) && ! unlink($leagueBasics->logo->thumbnail_path)) {
                throw new FileSystemException('There was an error when deleting the old logo thumbnail');
            }

            $leagueBasics->logo->delete();
        });
    }
}
