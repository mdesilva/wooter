<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\LeagueVideo;
use Wooter\Video;

class LeagueVideoRepository
{

    public function create(LeagueVideo $leagueVideo)
    {
        return $leagueVideo->push();
    }

    public function update(LeagueVideo $leagueVideo)
    {
        return $leagueVideo->push();
    }

    public function getById($leagueVideoId) {
        return LeagueVideo::whereId($leagueVideoId)->first();
    }

    public function getByVideoId($leagueVideoId) {
        return LeagueVideo::whereVideoId($leagueVideoId)->first();
    }


    public function getByLeagueIdWithPagination($params)
    {

        if($params['orderByVideosType'] == 'Qnap'):
            $videoOrder = 'DESC';
            else:
            $videoOrder = 'ASC';
        endif;
        $query = DB::table('league_videos');
        $query->leftjoin('videos', 'league_videos.video_id', '=', 'videos.id');

        if($params['getVideosType'] == 'All'):
            $query->select('league_videos.id');
        elseif($params['getVideosType'] == 'Qnap'):
            $query->select('league_videos.id')->whereType(Video::QNAP);
        else:
            $query->select('league_videos.id')->whereType(Video::WOOTER);
        endif;
        $leagueVideoIds =$query->whereLeagueId($params["leagueId"])->lists('id');
        $pages = $this->paginateVideos(count($leagueVideoIds), $params['limit']);
        $leagueVideoIds =$query->orderBy('videos.'.$params['orderBy'], $params['orderDirection'])->skip($params['offset'])->take($params['limit'])->lists('id');
        $videos = LeagueVideo::whereIn('id', $leagueVideoIds)->orderBy($params['orderBy'], $params['orderDirection'])->get();


        return [
            'videos' => $videos,
            'pages' => $pages
        ];



    }

    public function readAllQnapVideos()
    {


        $query = DB::table('league_videos');

        $query->leftjoin('videos', 'league_videos.video_id', '=', 'videos.id');
        $query->where('videos.type', '=', Video::QNAP);
        $query->select('league_videos.id');
        $leagueVideoIds =$query->distinct()->lists('id');
        return LeagueVideo::whereIn('id', $leagueVideoIds)->get();



    }

    public function getVideoByGameAndLeagueId($leagueId, $gameId, $offset, $limit)
    {

        return LeagueVideo::whereLeagueId($leagueId)->whereGameId($gameId)->get()->slice($offset, $limit);
    }

    private function paginateVideos($total, $limit)
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
