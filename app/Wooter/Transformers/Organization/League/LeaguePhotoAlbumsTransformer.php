<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeaguePhotoAlbumsTransformer extends Transformer
{
    public function transform($album)
    {


        return [
            'id' => $album->id,
            'name' => $album->album_name

        ];

    }
}