<?php

namespace Wooter\Wooter\Repositories\Team;

use Illuminate\Support\Facades\DB;
use Wooter\Team;
use Wooter\LeagueVideo;
use Wooter\Video;
use Wooter\LeaguePhoto;
use Wooter\Image;
class TeamRepository
{

    public function create(Team $team)
    {
        return $team->push();
    }

    public function update(Team $team)
    {
        return $team->push();
    }

    public function getById($teamId) {
        return Team::whereId($teamId)->first();
    }
    
    public function getFromIds($teamIds)
    {
        return Team::whereIn('id', $teamIds)->get();
    }

    public function getMailRecipientsFromIds($teamIds)
    {
        $teams = Team::whereIn('id', $teamIds)->get();
        
        $recipients = [];
        foreach ($teams as $team) {
            $recipients[] = $team;
            $players = $team->players;
            
            foreach ($players as $player) {
                $recipients[] = $player;
            }
        }
        
        return collect($recipients);
    }

    public function getTeamPlayersJoinedLeague($teamId, $leagueId)
    {
        $playerIds = [];

        $players =  Team::find( $teamId )->players()->whereHas('leagues',
            function($query) use($leagueId)
            {
                $query->where('leagues.id', '=', $leagueId );

            })->get();

        foreach($players as $player=>$member){

            $playerIds[] = $member->id;
        }

        return $playerIds;
    }
    public function getLeagueFromLeagueid($leagueId)
    {
        return Team::where('league_id',$leagueId)->get();
    }
    
    public function search($params) {
        $query = DB::table('teams');


        if (isset($params['leagueId']) && $params['leagueId'] !== '' && $params['leagueId'] !== false) {
            $query->leftjoin('team_league', 'team_league.team_id', '=', 'teams.id');
            $query->where('team_league.league_id', '=', $params['leagueId']);
        }

        if (isset($params['divisionId']) && $params['divisionId'] !== '' && $params['divisionId'] !== false) {
            $query->leftjoin('team_division', 'team_division.team_id', '=', 'teams.id');
            $query->where('team_division.division_id', '=', $params['divisionId']);
        }

        if (isset($params['q']) && $params['q'] !== '' && $params['q'] !== false) {
            $query->whereRaw('lower(teams.name) LIKE lower(?)', ['%'.$params['q'].'%']);
        }

        $teamIds = $query->distinct()->lists('teams.id');

        if (isset($params['all']) && $params['all'] == true) {
            $pages = 0;
            $teams = Team::whereIn('id', $teamIds)->get();
        } else {
            $pages = $this->paginateTeams(count($teamIds), $params['limit']);
            $teams = Team::whereIn('id', $teamIds)->orderBy($params['orderBy'], $params['orderDirection'])->skip($params['offset'])->take($params['limit'])->get();
        }

        return [
            'teams' => $teams,
            'pages' => $pages
        ];
    }

    public function getTeamVideosWithPagination($params)
    {
        if($params['orderByVideosType'] == 'Qnap'):
            $videoOrder = 'DESC';
        else:
            $videoOrder = 'ASC';
        endif;
        $query = DB::table('league_videos');
        $query->leftjoin('videos', 'league_videos.video_id', '=', 'videos.id');
        $query->leftjoin('league_team_videos', 'league_videos.id', '=', 'league_team_videos.league_video_id');
        if($params['getVideosType'] == 'All'):
            $query->select('league_videos.id');
        elseif($params['getVideosType'] == 'Qnap'):
            $query->select('league_videos.id')->whereType(Video::QNAP);
        else:
            $query->select('league_videos.id')->whereType(Video::WOOTER);
        endif;
        $leagueVideoIds =$query->whereTeamId($params["teamId"])->lists('id');

        $pages = $this->paginateTeams(count($leagueVideoIds), $params['limit']);

        $leagueVideoIds =$query->orderBy('videos.'.$params['orderBy'], $params['orderDirection'])->skip($params['offset'])->take($params['limit'])->lists('id');
        $videos = LeagueVideo::whereIn('id', $leagueVideoIds)->orderBy($params['orderBy'], $params['orderDirection'])->get();



        return [
            'videos' => $videos,
            'pages' => $pages
        ];
    }

    public function getTeamPhotosWithPagination($params)
    {

        $query = DB::table('league_photos');
        $query->leftjoin('images', 'league_photos.image_id', '=', 'images.id');
        $query->leftjoin('league_team_photos', 'league_photos.id', '=', 'league_team_photos.league_photo_id');

            $query->select('league_photos.id');

        $leaguePhotosIds =$query->whereTeamId($params["teamId"])->lists('id');

        $pages = $this->paginateTeams(count($leaguePhotosIds), $params['limit']);
        $leaguePhotosIds =$query->skip($params['offset'])->take($params['limit'])->lists('id');
        $photos = LeaguePhoto::whereIn('id', $leaguePhotosIds)->orderBy($params['orderBy'], $params['orderDirection'])->get();


        return [
            'photos' => $photos,
            'pages' => $pages
        ];
    }
    
    private function paginateTeams($total, $limit) 
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
