<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeagueTagPhotoTransformer extends Transformer
{
    public function transform($leagueTagPhotos)
    {

        $tags = [];

       foreach($leagueTagPhotos as $tag)
       {

           $tags[] = $tag->id;
       }
    return $tags;
    }
}