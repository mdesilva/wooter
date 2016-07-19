<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Carbon\Carbon;
use Wooter\Wooter\Transformers\Transformer;


class LeagueGameVideosTransformer extends Transformer
{


    public function transform($leagueGames)
    {

        $video = $leagueGames->video;

        return array(
            "league_id" => $leagueGames->league_id,
            "video_id" => $leagueGames->video_id,
            "label_id" => $leagueGames->label_id,
            "game_id" => $leagueGames->game_id,
            "file_name"     => $video->file_name,
            "file_path"     => $video->file_path,
            "thumbnail_path" => $video->thumbnail_path,
            "size"          => $video->size,
            "mime_type"     => $video->mime_type,
            "extension"     => $video->extension,
            "description"   => $video->description,
            "date"          => $leagueGames->created_at->format('d/m/Y H:i:s'),

        );
    }
}

