<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;


class LeaguePlayerPhotosTransformer extends Transformer
{


    public function transform($leaguePlayerPhoto)
    {

        return array(
            'league_id'     => $leaguePlayerPhoto->league_id,
            'image_id'      => $leaguePlayerPhoto->image_id,
            'album_id'      => $leaguePlayerPhoto->album_id,
            "game_id"       => $leaguePlayerPhoto->game_id,
            "file_name"     => $leaguePlayerPhoto->file_name,
            "file_path"     => $leaguePlayerPhoto->file_path,
            "thumbnail_path" => $leaguePlayerPhoto->thumbnail_path,
            "size"          => $leaguePlayerPhoto->size,
            "mime_type"     => $leaguePlayerPhoto->mime_type,
            "extension"     => $leaguePlayerPhoto->extension,
            "role"          => $leaguePlayerPhoto->role,
            "description"   => $leaguePlayerPhoto->description,

             );




    }
}