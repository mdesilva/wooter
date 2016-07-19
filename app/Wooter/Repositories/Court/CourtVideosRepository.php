<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\CourtVideo;

class CourtVideosRepository
{

    public function create(Courtvideo $video)
    {
        return $video->save();
    }

    public function update(CourtVideo $video)
    {
        return $video->save();
    }

    public function getById($video_id)
    {
        return CourtVideo::whereId($video_id)->first();
    }
}

