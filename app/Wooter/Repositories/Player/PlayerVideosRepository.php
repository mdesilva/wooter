<?php

namespace Wooter\Wooter\Repositories\Player;
use DB;
use Wooter\LeagueVideo;
use Wooter\Video;


class PlayerVideosRepository
{
    public function getPlayerVideosWithPagination($params)
    {


        if($params['orderByVideosType'] == 'Qnap'):
            $videoOrder = 'DESC';
        else:
            $videoOrder = 'ASC';
        endif;
        $query = DB::table('league_videos');
        $query->leftjoin('videos', 'league_videos.video_id', '=', 'videos.id');
        $query->leftjoin('league_player_videos', 'league_videos.id', '=', 'league_player_videos.league_video_id');
        if($params['getVideosType'] == 'All'):
            $query->select('league_videos.id');
        elseif($params['getVideosType'] == 'Qnap'):
            $query->select('league_videos.id')->whereType(Video::QNAP);
        else:
            $query->select('league_videos.id')->whereType(Video::WOOTER);
        endif;
        $leagueVideoIds =$query->wherePlayerId($params["playerId"])->lists('id');

        $pages = $this->paginatePlayers(count($leagueVideoIds), $params['limit']);
        $leagueVideoIds =$query->orderBy('videos.'.$params['orderBy'], $params['orderDirection'])->skip($params['offset'])->take($params['limit'])->lists('id');
        $videos = LeagueVideo::whereIn('id', $leagueVideoIds)->orderBy($params['orderBy'], $params['orderDirection'])->get();


        return [
            'videos' => $videos,
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