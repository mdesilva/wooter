<?php

namespace Wooter\Wooter\Repositories\Game;

use Illuminate\Support\Facades\DB;
use Wooter\Game;
use Wooter\LeagueVideo;
use Wooter\Video;
use Wooter\LeaguePhoto;
use Carbon\Carbon;


class GamesRepository
{

    public function create(Game $game)
    {
        return $game->push();
    }

    public function update(Game $game)
    {
        return $game->push();
    }

    public function getById($game_id) {
        return Game::whereId($game_id)->first();
    }

    public function getBySeasonId($season_id) {
        return Game::whereSeasonId($season_id)->get();
    }

    public function getWinsByTeamIdAndStage($teamId, $stageType, $stageId)
    {
        $winsAtHome = Game::whereStageType($stageType)->whereStageId($stageId)->
        whereHomeTeamId($teamId)->whereRaw('home_team_score > visiting_team_score')->count();
        $winsVisiting = Game::whereStageType($stageType)->whereStageId($stageId)->
        whereVisitingTeamId($teamId)->whereRaw('visiting_team_score > home_team_score')->count();
        return $winsAtHome + $winsVisiting;
    }

    public function getLossesByTeamIdAndStage($teamId, $stageType, $stageId)
    {
        $lossesAtHome = Game::whereStageType($stageType)->whereStageId($stageId)->
        whereHomeTeamId($teamId)->whereRaw('home_team_score < visiting_team_score')->count();
        $lossesVisiting = Game::whereStageType($stageType)->whereStageId($stageId)->
        whereVisitingTeamId($teamId)->whereRaw('visiting_team_score < home_team_score')->count();
        return $lossesAtHome + $lossesVisiting;
    }

    public function getDrawsByTeamIdAndStage($teamId, $stageType, $stageId)
    {
        $drawsAtHome = Game::whereStageType($stageType)->whereStageId($stageId)->
        whereHomeTeamId($teamId)->whereRaw('home_team_score = visiting_team_score')->count();
        $drawsVisiting = Game::whereStageType($stageType)->whereStageId($stageId)->
        whereVisitingTeamId($teamId)->whereRaw('home_team_score = visiting_team_score')->count();
        return $drawsAtHome + $drawsVisiting;
    }

    public function getGamesPlayedByTeamIdAndStage($teamId, $stageType, $stageId)
    {
        $gamesPlayedAtHome = Game::whereStageType($stageType)->whereStageId($stageId)->
        whereHomeTeamId($teamId)->count();
        $gamesPlayedVisiting = Game::whereStageType($stageType)->whereStageId($stageId)->
        whereVisitingTeamId($teamId)->count();
        return $gamesPlayedAtHome + $gamesPlayedVisiting;
    }

    public function getPointsByTeamsId($teamId)
    {
        return 1;
    }

    public function deleteById($gameId){
        return Game::whereId($gameId)->delete();
    }

    public function getByLeagueId($league_id) {
        $games = Game::all();
        $games_list = [];
        foreach ($games as $game) {
            if ($game->competition_type == 'Wooter\League' && $game->competition->id == $league_id) {
                $games_list[] = $game;
            } else if ($game->competition->league_id == $league_id) {
                $games_list[] = $game;
            }
        }

        return collect($games_list);
    }
    
    public function search($params)
    {
        $query = DB::table('games');
        
        $organizationTable = $this->getOrganizationTable($params);
        $organizationId = $this->getOrganizationId($params);
        $competitionTable = $this->getCompetitionTable($params);
        $competitionId = $this->getCompetitionId($params);
        $stageTable = $this->getStageTable($params);
        $stageId = $this->getStageId($params);
        
        $query = $this->joinTables($query, $organizationTable, $competitionTable, $stageTable);
        $query = $this->filterGames($query, $params, $organizationTable, $organizationId, $competitionTable, $competitionId);
        $gameIds = $query->distinct()->lists('games.id');

        if ($params['all']) {
            $pages = 0;
            $games = Game::whereIn('id', $gameIds)->get();
        } else {
            $pages = $this->paginateGames(count($gameIds), $params['limit']);
            $games = Game::whereIn('id', $gameIds)->orderBy($params['order_by'], $params['order_direction'])->skip($params['offset'])->take($params['limit'])->get();

            if (($params['pick'] === '0') || (isset($params['pick']) && $params['pick'] !== '' && $params['pick'] !== false)) {
                $pick = ($params['pick'] > 0) ? $params['pick'] - 1 : $params['pick'];
                $games = $games->slice($pick, 1);
            }
        }
        
        $games = $this->filterByScored($games, $params['scored']);


        return [
            'games' => $games,
            'pages' => $pages
        ];
    }
    
    private function filterGames($query, $params, $organizationTable, $organizationId, $competitionTable, $competitionId) {
        $query = $this->filterByOrganizationId($query, $organizationTable, $organizationId);
        $query = $this->filterByCompetitionId($query, $competitionTable, $competitionId);
        $query = $this->filterByWeekId($query, $params['week_id']);
        $query = $this->filterByPlayerId($query, $params['player_id']);
        $query = $this->filterByTeamId($query, $params['team_id']);
        $query = $this->filterByStatus($query, $params['game_status']);
        return $query;
    }
    
    private function getOrganizationTable($params) {
        $organizationType = 'Wooter\LeagueOrganization';
        switch($organizationType) {
            case 'Wooter\LeagueOrganization':
                $organizationTable = 'league_organizations';
                break;
            case false:
                $organizationTable = 'league_organizations';
                break;
        }
        
        return $organizationTable;
    }
    
    private function getOrganizationId($params) {
        $organizationType = 'Wooter\LeagueOrganization';
        switch($organizationType) {
            case 'Wooter\LeagueOrganization':
                $organizationId = $params['league_id'];
                break;
            case false:
                $organizationId = $params['league_id'];
                break;
        }
        
        return $organizationId;
    }
    
    private function getCompetitionTable($params) {
        switch($params['competition_type']) {
            case 'Wooter\SeasonCompetition':
                $competitionTable = 'season_competitions';
                break;
            case 'Wooter\TournamentCompetition':
                $competitionTable = 'tournament_competitions';
                break;
            case false:
                $competitionTable = 'season_competitions';
        }
        
        return $competitionTable;
    }
    
    private function getCompetitionId($params) {
       return $params['competition_id'];
    }
    
    private function getStagetable($params) {
        return 'regular_stages';
    }
    
    private function getStageId($params) {
        return null;
    }
    
    private function joinTables($query, $organizationTable, $competitionTable, $stageTable) {
        $query->leftjoin($stageTable, $stageTable . '.id', '=', 'games.stage_id');
        $query->leftjoin($competitionTable, $competitionTable . '.id', '=', $stageTable . '.competition_id');
        $query->leftjoin($organizationTable, $organizationTable . '.id', '=', $competitionTable . '.organization_id');
        $query->leftjoin('player_team as player_team_1', 'player_team_1.team_id', '=', 'games.home_team_id');
        $query->leftjoin('player_team as player_team_2', 'player_team_2.team_id', '=', 'games.visiting_team_id');
        
        return $query;
    }
    
    private function filterByOrganizationId($query, $organizationTable, $organizationId) {
        if (isset($organizationId) && $organizationId !== '' && $organizationId !== false) {
            $query->where($organizationTable . '.id', '=', $organizationId);
        }
        
        return $query;
    }
    
    private function filterByCompetitionId($query, $competitionTable, $competitionId) {
        if (isset($competitionId) && $competitionId !== '' && $competitionId !== false) {
            $query->where($competitionTable . '.id', '=', $competitionId);
        }
        
        return $query;
    }
    
    private function filterByWeekId($query, $weekId) {
        if (isset($weekId) && $weekId !== '' && $weekId !== false) {
            $query->where('games.competition_week_id', '=', $weekId);
        }
        
        return $query;
    }
    
     private function filterByPlayerId($query, $playerId) {
        if (isset($playerId) && $playerId !== '' && $playerId !== false) {
            $query->where(function($query) use ($playerId) {
                $query->where('player_team_1.player_id', '=', $playerId)
                      ->orWhere('player_team_2.player_id', '=', $playerId);
            });
        }
        
        return $query;
    }
    
     private function filterByTeamId($query, $teamId) {
        if (isset($teamId) && $teamId !== '' && $teamId !== false) {
            $query->where(function($query) use ($teamId) {
                $query->where('games.home_team_id', '=', $teamId)
                      ->orWhere('games.visiting_team_id', '=', $teamId);
            });
        }
        
        return $query;
    }
    
    private function filterByStatus($query, $gameStatus) {
        switch ($gameStatus) {
            case 'completed':
                $query->where('games.time', '<', Carbon::now());
                break;
            case 'scheduled':
                $query->where('games.time', '>', Carbon::now());
                break;
        }
        
        return $query;
    }
    
    private function filterByScored($games, $scored) {
        $scoredGames = [];
        if ($scored == 'true') {
            foreach ($games as $game) {
                $homeTeamStats = $game->homeTeam->stats()->where('game_id', $game->id)->first();
                $home_team_win = $homeTeamStats ? $homeTeamStats->win : '';
                $home_team_loss = $homeTeamStats ? $homeTeamStats->loss : '';
                $home_team_draw = $homeTeamStats ? $homeTeamStats->draw : '';
                
                $isScored = $home_team_win + $home_team_loss + $home_team_draw;
                
                if ($isScored) {
                    $scoredGames[] = $game;
                }
            }
            
            $games = collect($scoredGames);
        }
        
        return $games;
    }
    
    private function paginateGames($total, $limit) 
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

    /**
     * Return game videos on the basis of request params
     *
     * @param $params
     * @return array
     */
    public function getGameVideosWithPagination($params)
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
        $leagueVideoIds =$query->whereGameId($params["gameId"])->lists('id');
        $pages = $this->paginateGames(count($leagueVideoIds), $params['limit']);

        $leagueVideoIds =$query->orderBy('videos.'.$params['orderBy'], $params['orderDirection'])->skip($params['offset'])->take($params['limit'])->lists('id');
        $videos = LeagueVideo::whereIn('id', $leagueVideoIds)->orderBy($params['orderBy'], $params['orderDirection'])->get();

        return [
            'videos' => $videos,
            'pages' => $pages
        ];
    }


    public function getGamePhotosWithPagination($params)
    {



        $query = DB::table('league_photos');
        $query->leftjoin('images', 'league_photos.image_id', '=', 'images.id');

        $query->select('league_photos.id');

        $leaguePhotoIds =$query->whereGameId($params["gameId"])->lists('id');
        $pages = $this->paginateGames(count($leaguePhotoIds), $params['limit']);
        $leaguePhotoIds =$query->skip($params['offset'])->take($params['limit'])->lists('id');
        $photos = LeaguePhoto::whereIn('id', $leaguePhotoIds)->orderBy($params['orderBy'], $params['orderDirection'])->get();


        return [
            'photos' => $photos,
            'pages' => $pages
        ];
    }

}
