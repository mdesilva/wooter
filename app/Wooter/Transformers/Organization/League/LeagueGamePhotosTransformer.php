<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;


class LeagueGamePhotosTransformer extends Transformer
{


    public function transform($leagueGames)
    {
        $photo = $leagueGames->photo;

        return array(
            'league_id'     => $leagueGames->league_id,
            'image_id'      => $leagueGames->image_id,
            'album_id'      => $leagueGames->album_id,
            "game_id"       => $leagueGames->game_id,
            "file_name"     => $photo->file_name,
            "file_path"     => $photo->file_path,
            "thumbnail_path" => $photo->thumbnail_path,
            "size"          => $photo->size,
            "mime_type"     => $photo->mime_type,
            "extension"     => $photo->extension,
            "role"          => $photo->role,
            "description"   => $photo->description,
            "date"          => $leagueGames->created_at->format('d/m/Y H:i:s'),
             );




    }
}