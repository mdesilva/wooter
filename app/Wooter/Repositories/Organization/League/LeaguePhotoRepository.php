<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeaguePhoto;
use Wooter\LeagueVideo;

class LeaguePhotoRepository
{

    public function create(LeaguePhoto $leaguePhoto)
    {
        return $leaguePhoto->push();
    }

    public function update(LeaguePhoto $leaguePhoto)
    {
        return $leaguePhoto->push();
    }

    public function getById($leaguePhotoId) {
        return LeaguePhoto::whereId($leaguePhotoId)->first();
    }

    public function getByLeagueIdAndImageId($leagueId, $imageId) {
        return LeaguePhoto::whereLeagueId($leagueId)->whereImageId($imageId)->first();
    }

    public function getByImageId($imageId) {
        return LeaguePhoto::where('image_id', $imageId)->first();
    }

    public function getByLeagueId($leagueId) {
        return LeaguePhoto::whereLeagueId($leagueId)->get();
    }

    public function getByLeagueIdWithPagination($params)
    {


        $query = DB::table('league_photos');
        $query->leftjoin('images', 'league_photos.image_id', '=', 'images.id');


        $query->select('league_photos.id');

        $leaguePhotosIds =$query->whereLeagueId($params["leagueId"])->lists('id');

        $pages = $this->paginatePhotos(count($leaguePhotosIds), $params['limit']);

        $videos = LeaguePhoto::whereIn('id', $leaguePhotosIds)->orderBy($params['orderBy'], $params['orderDirection'])->skip($params['offset'])->take($params['limit'])->get();


        return [
            'photos' => $videos,
            'pages' => $pages
        ];

        //return LeaguePhoto::whereLeagueId($leagueId)->paginate();
    }

    public function getPhotoByGameAndLeagueId($leagueId, $gameId, $offset, $limit)
    {
        return LeaguePhoto::whereLeagueId($leagueId)->whereGameId($gameId)->get()->slice($offset, $limit);
    }
    
    public function getByLeagueAndTeamId($leagueId, $teamId) {
        return LeaguePhoto::whereLeagueId($leagueId)
                          ->whereTeamId($teamId)
                          ->get();
    }

    /**
     * all league photos associated with player
     *
     * @param $leagueId
     * @param $playerId
     * @return mixed
     */
    public function getPlayerPhotosByLeagueIdAndPlayerId($leagueId, $playerId, $offset, $limit)
    {
        $query = DB::table('images');
        $query->select('*');

        $query->leftjoin('league_photos', 'league_photos.image_id', '=', 'images.id');
        $query->leftjoin('league_player_photos', 'league_player_photos.league_photo_id', '=', 'league_photos.id');

        $query->where('league_photos.league_id', '=', $leagueId);
        $query->where('league_player_photos.player_id', '=', $playerId);

        $playerPhotos = $query->skip($offset)->take($limit)->get();

        return $playerPhotos;
    }

    /**
     * all league photos associated with team
     *
     * @param $leagueId
     * @param $teamId
     * @return mixed
     */
    public function getPlayerPhotosByLeagueIdAndTeamId($leagueId, $teamId, $offset, $limit)
    {
        $query = DB::table('images');
        $query->select('*');

        $query->leftjoin('league_photos', 'league_photos.image_id', '=', 'images.id');
        $query->leftjoin('league_team_photos', 'league_team_photos.league_photo_id', '=', 'league_photos.id');

        $query->where('league_photos.league_id', '=', $leagueId);
        $query->where('league_team_photos.team_id', '=', $teamId);

        $teamPhotos = $query->skip($offset)->take($limit)->get();

        return $teamPhotos;
    }


    /**
     * all league videos associated with player
     *
     * @param $leagueId
     * @param $playerId
     * @return mixed
     */

    public function getPlayerVideosByLeagueIdAndPlayerId($leagueId, $playerId, $offset, $limit)
    {
        $query = DB::table('videos');
        $query->select('*');

        $query->leftjoin('league_videos', 'league_videos.video_id', '=', 'videos.id');
        $query->leftjoin('league_player_videos', 'league_player_videos.league_video_id', '=', 'league_videos.id');
        $query->where('league_videos.league_id', '=', $leagueId);
        $query->where('league_player_videos.player_id', '=', $playerId);


        $playerVideos = $query->skip($offset)->take($limit)->get();
        return $playerVideos;
    }

    /**
     * all league videos associated with team
     * 
     * @param $leagueId
     * @param $teamId
     * @return mixed
     */
    public function getTeamVideosByLeagueIdAndPlayerId($leagueId, $teamId, $offset, $limit)
    {
        $query = DB::table('videos');
        $query->select('*');

        $query->leftjoin('league_videos', 'league_videos.video_id', '=', 'videos.id');
        $query->leftjoin('league_team_videos', 'league_team_videos.league_video_id', '=', 'league_videos.id');
        $query->where('league_videos.league_id', '=', $leagueId);
        $query->where('league_team_videos.team_id', '=', $teamId);


        $teamVideos = $query->skip($offset)->take($limit)->get();
        return $teamVideos;
    }



    private function paginatePhotos($total, $limit)
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
