<?php

namespace Wooter\Wooter\Repositories;

use Wooter\Video;

class VideoRepository
{

    public function create(Video $image)
    {
        return $image->save();
    }

    public function update(Video $image)
    {
        return $image->save();
    }

    public function getById($imageId) {
        return Video::whereId($imageId)->first();
    }

    public function getVideoByHash($hash)
    {
        return Video::whereVideoHash($hash)->whereType(Video::QNAP)->first();
    }

}
