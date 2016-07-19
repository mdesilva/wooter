<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;


class LeaguePlayerVideosTransformer extends Transformer
{


    public function transform($leaguePlayerVideo)
    {

        return array(
            'league_id'     => $leaguePlayerVideo->league_id,
            'video_id'      => $leaguePlayerVideo->video_id,
            'label_id'      => $leaguePlayerVideo->label_id,
            "game_id"       => $leaguePlayerVideo->game_id,
            "file_name"     => $leaguePlayerVideo->file_name,
            "file_path"     => $leaguePlayerVideo->file_path,
            "thumbnail_path"=> $leaguePlayerVideo->thumbnail_path,
            "size"          => $leaguePlayerVideo->size,
            "mime_type"     => $leaguePlayerVideo->mime_type,
            "extension"     => $leaguePlayerVideo->extension,

           );




    }
}