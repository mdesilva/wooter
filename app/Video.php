<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    /**
     *
     * set video type to wooter 2.0 uploaded videos
     */
    const WOOTER = 1;
    /**
     *
     * set video type to Qnap server video
     */
    const QNAP = 2;
    const YOUTUBE_SRC = 'http://www.youtube.com/embed/%VIDEOID%';
    const YOUTUBE_THUMB = 'http://img.youtube.com/vi/%VIDEOID%/0.jpg';


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name',
        'file_source',
        'mime_type',
        'extension',
        'size',
        'description',
        'type',
        'youtube_src',
        'cdn_src',
        'video_hash'
    ];
}
