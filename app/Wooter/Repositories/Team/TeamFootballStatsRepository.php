<?php

namespace Wooter\Wooter\Repositories\Team;

use Illuminate\Support\Facades\DB;
use Wooter\TeamFootballStat;

class TeamFootballStatsRepository
{

    public function create(TeamFootballStat $stats)
    {
        return $stats->save();
    }

    public function update(TeamFootballStat $stats)
    {
        return $stats->save();
    }

    public function getById($id) {
        return TeamFootballStat::whereId($id)->first();
    }
    
    public function getByGameId($gameId) {
        return TeamFootballStat::whereGameId($gameId)->get();
    }
    
    public function getByTeamAndGameId($teamId, $gameId) {
        return TeamFootballStat::whereTeamId($teamId)->whereGameId($gameId)->first();
    }
    
    public function search($params) {
        $returnAllTeams = true;
        $query = DB::table('team_football_stats');
        
        $query->leftjoin('games', 'games.id', '=', 'team_football_stats.game_id');
        $query->leftjoin('regular_stages', 'regular_stages.id', '=', 'games.stage_id');
        $query->leftjoin('season_competitions', 'season_competitions.id', '=', 'regular_stages.competition_id');
        $query->leftjoin('league_organizations', 'league_organizations.id', '=', 'season_competitions.organization_id');
        
        if (isset($params['teamId']) && $params['teamId'] !== '' && $params['teamId'] !== false) {
            $query->where('team_football_stats.team_id', '=', $params['teamId']);
            $returnAllTeams = false;
        }
        
        if (isset($params['gameId']) && $params['gameId'] !== '' && $params['gameId'] !== false) {
            $query->where('games.id', '=', $params['gameId']);
            $returnAllTeams = true;
        }
        
        if (isset($params['stageId']) && $params['stageId'] !== '' && $params['stageId'] !== false) {
            $query->where('regular_stages.id', '=', $params['stageId']);
        }
        
        if (isset($params['seasonId']) && $params['seasonId'] !== '' && $params['seasonId'] !== false) {
            $query->where('season_competitions.id', '=', $params['seasonId']);
        }
        
        if (isset($params['leagueId']) && $params['leagueId'] !== '' && $params['leagueId'] !== false) {
            $query->where('league_organizations.id', '=', $params['leagueId']);
        }
        
        $leagueId = $params['leagueId'];
        $ids = $query->lists('team_football_stats.id');
        $limit = ($params['limit'] == 'all') ? count($ids) : $params['limit'];
        $teams = Team::whereHas('leagues', function($query) use ($leagueId) {
            $query->where('league_organizations.id', '=', $leagueId);
        })->orderBy($params['orderBy'], $params['orderDirection'])->get(); //->skip($params['offset'])->take($limit)->get();
        
        $totalTeamIds = $teams->lists('id');
        $teams = $teams->slice($params['offset'], $limit);
        $teamIds = $teams->lists('id');
        $stats = TeamFootballStat::whereIn('id', $ids)->get();
        $teamStats = $this->filterTeamStats($stats, $teamIds);
        $teamStats = $this->filterByScored($teamStats);
        $blankStats = [];
        if ($returnAllTeams) {
            $blankStats = $this->getBlankStats($teams, $teamStats->lists('team_id'));
        }
        foreach ($blankStats as $blankStat) {
            $teamStats->push($blankStat);
        }
        
        $pages = ($params['limit'] != 'all') ? $this->paginateTeamStats(count($totalTeamIds) , $params['limit']) : 1;
        
        return [
            'stats' => $teamStats,
            'pages' => $pages
        ];
    }
    
    private function filterTeamStats($stats, $teamIds) {
        $teamStats = [];
        $teamIdsArray = [];
        foreach ($teamIds as $id) {
            $teamIdsArray[] = $id;
        }
        foreach ($stats as $stat) {
            if (in_array($stat->team_id, $teamIdsArray)) {
                $teamStats[] = $stat;
            }
        }
        
        return collect($teamStats);
    }
    
    private function getBlankStats($teams, $teamIds) {
        $blankStats = [];
        $teamIdsArray = [];
        foreach ($teamIds as $teamId) {
            $teamIdsArray[] = $teamId;
        }
        foreach ($teams as $team) {
            if (!in_array($team->id, $teamIdsArray)) {
                $stats = new TeamFootballStat();
                $stats->team_id = $team->id;
                $stats->game_id = 0;
                $stats->first_quarter_score = 0;
                $stats->second_quarter_score = 0;
                $stats->third_quarter_score = 0;
                $stats->fourth_quarter_score = 0;
                $stats->final_score = 0;
                $stats->win = 0;
                $stats->loss = 0;
                $stats->draw = 0;
                $blankStats[] = $stats;
            }
        }
        
        return $blankStats;
    }
    
    private function filterByScored($stats) {
        $scoredGameStats = [];
        foreach ($stats as $stat) {
            $isScored = $stat->win + $stat->loss + $stat->draw;
            if ($isScored) {
                $scoredGameStats[] = $stat;
            }
        }
        
        return collect($scoredGameStats);
    }
    
    private function paginateTeamStats($total, $limit) 
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

