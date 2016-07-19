<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;


class LeagueTeamPhotosTransformer extends Transformer
{


    public function transform($leagueTeamPhoto)
    {

        return array(
            'id'            => $leagueTeamPhoto->id,
            'league_id'     => $leagueTeamPhoto->league_id,
            'image'      => $leagueTeamPhoto->photo->toArray(),
            'album_id'      => $leagueTeamPhoto->album_id,
            "game_id"       => $leagueTeamPhoto->game_id,
            'team_id'       => $leagueTeamPhoto->team_id,
            'division_id'   => $leagueTeamPhoto->division_id,
            //"file_name"     => $leagueTeamPhoto->file_name,
            //"file_path"     => $leagueTeamPhoto->file_path,
            //"thumbnail_path" => $leagueTeamPhoto->thumbnail_path,
            //"size"          => $leagueTeamPhoto->size,
            //"mime_type"     => $leagueTeamPhoto->mime_type,
            //"extension"     => $leagueTeamPhoto->extension,
            //"role"          => $leagueTeamPhoto->role,
            //"description"   => $leagueTeamPhoto->description,

             );

    }
}