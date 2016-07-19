<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;


class LeagueTeamVideosTransformer extends Transformer
{


    public function transform($leagueTeamVideo)
    {

        return array(
            'league_id'     => $leagueTeamVideo->league_id,
            'video_id'      => $leagueTeamVideo->video_id,
            'label_id'      => $leagueTeamVideo->label_id,
            "game_id"       => $leagueTeamVideo->game_id,
            "file_name"     => $leagueTeamVideo->file_name,
            "file_path"     => $leagueTeamVideo->file_path,
            "thumbnail_path"=> $leagueTeamVideo->thumbnail_path,
            "size"          => $leagueTeamVideo->size,
            "mime_type"     => $leagueTeamVideo->mime_type,
            "extension"     => $leagueTeamVideo->extension,

           );




    }
}