<?php

namespace Wooter\Wooter\Repositories\Player;
use DB;
use Wooter\LeaguePhoto;
use Wooter\Image;


class PlayerPhotosRepository
{
    public function getPlayerPhotosWithPagination($params)
    {


        $query = DB::table('league_photos');
        $query->leftjoin('images', 'league_photos.image_id', '=', 'images.id');
        $query->leftjoin('league_player_photos', 'league_photos.id', '=', 'league_player_photos.league_photo_id');

        $query->select('league_photos.id');

        $leaguePhotosIds =$query->wherePlayerId($params["playerId"])->lists('id');

        $pages = $this->paginatePlayers(count($leaguePhotosIds), $params['limit']);
        $leaguePhotosIds =$query->skip($params['offset'])->take($params['limit'])->lists('id');
        $photos = LeaguePhoto::whereIn('id', $leaguePhotosIds)->orderBy($params['orderBy'], $params['orderDirection'])->get();


        return [
            'photos' => $photos,
            'pages' => $pages
        ];
    }

    private function paginatePlayers($total, $limit)
    {
        $quotient = $total / $limit;
        if ($quotient <= 1) {
            return 1;
        } else {
            $whole = floor($quotient);
            $fraction = $quotient - $whole;
            return $fraction ? $whole + 1 : $whole;
        }
    }
}