<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\ImageTransformer;
use Wooter\Wooter\Transformers\Transformer;

class LeaguePhotoTransformer extends Transformer
{
    /**
     * @var ImageTransformer
     */
    private $imageTransformer;
    /**
     * @var LeagueTagPhotoTransformer
     */
    private $leagueTagPhotoTransformer;

    /**
     * @param ImageTransformer                      $imageTransformer
     * @param LeagueTagPhotoTransformer $leagueTagPhotoTransformer
     */
    public function __construct(ImageTransformer $imageTransformer, LeagueTagPhotoTransformer $leagueTagPhotoTransformer) {
        $this->imageTransformer = $imageTransformer;
        $this->leagueTagPhotoTransformer = $leagueTagPhotoTransformer;
    }

    public function transform($leaguePhoto) {

         if(is_array($leaguePhoto)) {

          return $this->transformCollection($leaguePhoto);
        } else {

            $photo = [];
            if ($leaguePhoto->photo) {
                $photo = $this->imageTransformer->transform($leaguePhoto->photo);
            }

            $tagTeams = [];
            if($leaguePhoto->team_photos)
            {
                $tagTeams = $this->leagueTagPhotoTransformer->transform($leaguePhoto->team_photos);
            }

            $tagPlayers = [];
            if($leaguePhoto->player_photos)
            {
                $tagPlayers = $this->leagueTagPhotoTransformer->transform($leaguePhoto->player_photos);
            }

            return array_merge($photo, [
                'id'            => $leaguePhoto->id,
                'league_id'     => $leaguePhoto->league->id,
                'image_id'      => $leaguePhoto->image_id,
                'album_id'      => $leaguePhoto->album_id,
                "game_id"       => $leaguePhoto->game_id,
                "division_id"   => $leaguePhoto->division_id,
                "tagTeams"      => $tagTeams,
                "tagPlayers"    => $tagPlayers,
                "date"          => $leaguePhoto->created_at->format('d/m/Y H:i:s')
            ]);
        }
    }
}
