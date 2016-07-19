<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeaguePhotoAlbum;

class LeaguePhotoAlbumRepository
{


    public function create(LeaguePhotoAlbum $leaguePhotoAlbum)
    {
        return $leaguePhotoAlbum->save();
    }


    public function update(LeaguePhotoAlbum $leaguePhotoAlbum)
    {
        return $leaguePhotoAlbum->save();
    }

    public function getFromLeagueId($id)
    {
        return LeaguePhotoAlbum::where('league_id', intval($id))->get();

    }


    public function getById($id)
    {
        return LeaguePhotoAlbum::where('id', intval($id))->first();

    }
}
