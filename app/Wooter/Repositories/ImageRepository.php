<?php

namespace Wooter\Wooter\Repositories;

use Wooter\Image;

class ImageRepository
{

    public function create(Image $image)
    {
        return $image->push();
    }

    public function update(Image $image)
    {
        return $image->push();
    }

    public function getById($imageId)
    {
        return Image::whereId($imageId)->first();
    }

}
