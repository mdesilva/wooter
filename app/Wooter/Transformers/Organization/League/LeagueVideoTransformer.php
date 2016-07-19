<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Carbon\Carbon;
use Wooter\LeagueOrganization;
use Wooter\Wooter\Transformers\Transformer;
use Wooter\Video;

class LeagueVideoTransformer extends Transformer
{


    /**
     * @var LeaguePhotoTransformer
     */
    private $leagueTagPhotoTransformer;

    public function __construct(LeagueTagPhotoTransformer $leagueTagPhotoTransformer) {

        $this->leagueTagPhotoTransformer = $leagueTagPhotoTransformer;
    }



    public function transform($leagueVideo)
    {
        if(isset($leagueVideo->complete) && $leagueVideo->complete != "" ){

            if($leagueVideo->complete == "success"){

                $tagTeams = [];
                if($leagueVideo->team_videos)
                {
                    $tagTeams = $this->leagueTagPhotoTransformer->transform($leagueVideo->team_videos);
                }

                $tagPlayers = [];
                if($leagueVideo->player_videos)
                {
                    $tagPlayers = $this->leagueTagPhotoTransformer->transform($leagueVideo->player_videos);
                }
                $youTubeVideoSrc = "";
                $youTubeVideoThumb = "";

                if($leagueVideo->video->youtube_src)
                {
                    $youTubeVideoSrc = str_replace('%VIDEOID%', $leagueVideo->video->youtube_src, Video::YOUTUBE_SRC);
                    $youTubeVideoThumb = str_replace('%VIDEOID%', $leagueVideo->video->youtube_src, Video::YOUTUBE_THUMB);

                }

                return [
                    'id' => $leagueVideo->id,
                    'league_id' => $leagueVideo->league->id,
                    'label_id' => $leagueVideo->label_id,
                    'game_id' => $leagueVideo->game_id,
                    'video_id' => $leagueVideo->video_id,
                    'description' => $leagueVideo->video->description,
                    'mime_type' => $leagueVideo->video->mime_type,
                    'extension' => $leagueVideo->video->extension,
                    'size' => $leagueVideo->video->size,
                    'file_path' => $leagueVideo->video->file_path,
                    'thumbnail_path' => $leagueVideo->video->thumbnail_path,
                    'type' => $leagueVideo->video->type,
                    'file_name' => $leagueVideo->video->file_name,
                    'youtube_video_src' => $youTubeVideoSrc,
                    'youtube_video_thumb' => $youTubeVideoThumb,
                    'date' => $leagueVideo->video->created_at->format('d/m/Y H:i:s'),
                    "tagTeams"      => $tagTeams,
                    "tagPlayers"    => $tagPlayers,
                ];

            }else{
                return [
                    'video' => "in-progress"
                ];
            }

        }else{

            if( is_array($leagueVideo) )
            {

                return $this->transformCollection($leagueVideo);

            } else {

                $tagTeams = [];
                if($leagueVideo->team_videos)
                {
                    $tagTeams = $this->leagueTagPhotoTransformer->transform($leagueVideo->team_videos);
                }

                $tagPlayers = [];
                if($leagueVideo->player_videos)
                {
                    $tagPlayers = $this->leagueTagPhotoTransformer->transform($leagueVideo->player_videos);
                }
                $youTubeVideoSrc = "";
                $youTubeVideoThumb = "";
                if($leagueVideo->video->youtube_src)
                {
                    $youTubeVideoSrc = str_replace('%VIDEOID%', $leagueVideo->video->youtube_src, Video::YOUTUBE_SRC);
                    $youTubeVideoThumb = str_replace('%VIDEOID%', $leagueVideo->video->youtube_src, Video::YOUTUBE_THUMB);

                }

                return [
                    'id' => $leagueVideo->id,
                    'league_id' => $leagueVideo->league->id,
                    'label_id' => $leagueVideo->label_id,
                    'game_id' => $leagueVideo->game_id,
                    'video_id' => $leagueVideo->video_id,
                    'description' => $leagueVideo->video->description,
                    'mime_type' => $leagueVideo->video->mime_type,
                    'extension' => $leagueVideo->video->extension,
                    'size' => $leagueVideo->video->size,
                    'file_path' => $leagueVideo->video->file_path,
                    'thumbnail_path' => $leagueVideo->video->thumbnail_path,
                    'type' => $leagueVideo->video->type,
                    'file_name' => $leagueVideo->video->file_name,
                    'youtube_video_src' => $youTubeVideoSrc,
                    'youtube_video_thumb' => $youTubeVideoThumb,
                    'date' => $leagueVideo->video->created_at->format('d/m/Y H:i:s'),
                    "tagTeams"      => $tagTeams,
                    "tagPlayers"    => $tagPlayers,
                ];

            }

        }



    }
}