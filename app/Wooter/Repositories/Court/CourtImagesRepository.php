<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\CourtImage;

class CourtImagesRepository
{

    public function create(CourtImage $image)
    {
        return $image->save();
    }

    public function update(CourtImage $image)
    {
        return $image->save();
    }

    public function getById($image_id)
    {
        return CourtImage::whereId($image_id)->first();
    }
}

