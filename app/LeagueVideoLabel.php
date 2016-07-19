<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeagueVideoLabel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_video_labels';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label_name',
        'league_id'
    ];


    /**
     * The league that the video label belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }
}
