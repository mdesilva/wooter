<?php

namespace Wooter\Wooter\Repositories\Player;

use DB;
use Wooter\PlayerSoftballPitcherStat;

class PlayerSoftballPitcherStatsRepository
{

    public function create(PlayerSoftballPitcherStat $stat)
    {
        return $stat->save();
    }

    public function update(PlayerSoftballPitcherStat $stat)
    {
        return $stat->save();
    }

    public function getById($stat_id) {
        return PlayerSoftballPitcherStat::whereId($stat_id)->first();
    }
    
    public function getByLeagueId($league_id) {
        return PlayerSoftballPitcherStat::whereHas('league', function($query) use($league_id){
            $query->where('id', '=', $league_id);
        })->get();
    }
    
    public function getByPlayerAndLeagueId($player_id, $league_id) {
        return PlayerSoftballPitcherStat::whereHas('player', function($query) use($player_id){
            $query->where('id', '=', $player_id);
        })->whereHas('league', function($query) use($league_id){
            $query->where('id', '=', $league_id);
        })->get();
    }
    
    public function getByGameId($game_id) {
        return PlayerSoftballPitcherStat::where('game_id', '=', $game_id)->get();
    }
    
    public function deleteByGameId($game_id) {
        return PlayerSoftballPitcherStat::where('game_id', '=', $game_id)
                                   ->delete();
    }
    
    public function deleteByGameAndTeamId($game_id, $team_id) {
        return PlayerSoftballPitcherStat::where('game_id', '=', $game_id)
                                   ->where('team_id', '=', $team_id)
                                   ->delete();
    }
    
    public function search($params) {
        $query = DB::table('player_softball_pitcher_stats');
        
        $query->leftjoin('games', 'games.id', '=', 'player_softball_pitcher_stats.game_id');
        
        if (isset($params['game_id']) && $params['game_id'] !== '' && $params['game_id'] !== false) {
            $query->where('player_softball_pitcher_stats.game_id', '=', $params['game_id']);
        }
        
        $query = $this->filterByPlayerId($query, $params['player_id']);
        
        $statIds = $query->distinct()->lists('player_softball_pitcher_stats.id');
        $limit = ($params['limit'] == 'all') ? count($statIds) : $params['limit'];
        $stats = PlayerSoftballPitcherStat::whereIn('id', $statIds)
                                      ->orderBy($params['order_by'], $params['order_direction'])
                                      ->skip($params['offset'])
                                      ->take($limit)
                                      ->get();
        
        if (($params['pick'] === 0) || (isset($params['pick']) && $params['pick'] !== '' && $params['pick'] !== false)) {
            $pick = ($params['pick'] > 0) ? $params['pick'] - 1 : $params['pick'];
            $stats = $stats->slice($pick, 1);
        }
        
        return $stats;
    }
    
    public function searchForAverages($params)
    {
        $query = DB::table('player_softball_pitcher_stats');
        
        $organizationTable = $this->getOrganizationTable($params);
        $organizationId = $this->getOrganizationId($params);
        $competitionTable = $this->getCompetitionTable($params);
        $competitionId = $this->getCompetitionId($params);
        $stageTable = $this->getStageTable($params);
        $stageId = $this->getStageId($params);
        
        $query = $this->joinTables($query, $organizationTable, $competitionTable, $stageTable);
        $query = $this->filterByOrganizationId($query, $organizationTable, $organizationId);
        $query = $this->filterByCompetitionId($query, $competitionTable, $competitionId);
        $query = $this->filterByPlayerId($query, $params['player_id']);
        $query = $this->filterByTeamId($query, $params['team_id']);
        $query = $this->filterByActive($query, $params['active']);

        $league = LeagueOrganization::whereId($params['league_id'])->first();
        $leaguePlayers = $league->players;
        $ids = $leaguePlayers->lists('id');
        $limit = ($params['limit'] == 'all') ? count($ids) : $params['limit'];
        $players = User::whereIn('id', $ids)->orderBy($params['order_by'], $params['order_direction'])->get();
        
        $totalPlayerIds = $players->lists('id');
        $players = $players->slice($params['offset'], $limit);
        
        $statIds = $query->distinct()->lists('player_softball_pitcher_stats.id');
        $stats = PlayerSoftballPitcherStat::whereIn('id', $statIds)->get();
        $playerIds = $players->lists('id');
        $playerStats = $this->filterPlayerStats($stats, $playerIds);
        $playerStats = $this>filterByScored($playerStats);
        $blankStats = $this->getBlankStats($players);
        foreach ($blankStats as $blankStat) {
            $playerStats->push($blankStat);
        }
        
        $pages = ($params['limit'] != 'all') ? $this->paginatePlayerStats(count($totalPlayerIds) , $limit) : 1;
        $playerStats = $this->filterByScored($playerStats);
        
        return [
            'all' => $playerStats,
            'pages' => $pages
        ];
    }
    
    private function filterPlayerStats($stats, $playerIds) {
        $playerStats = [];
        $playerIdsArray = [];
        foreach ($playerIds as $id) {
            $playerIdsArray[] = $id;
        }
        foreach ($stats as $stat) {
            if (in_array($stat->player_id, $playerIdsArray)) {
                $playerStats[] = $stat;
            }
        }
        
        return collect($playerStats);
    }
    
    private function getBlankStats($players) {
        $blankStats = [];
        foreach ($players as $player) {
            if ($player->stats->count() === 0) {
                $stats = new PlayerSoftballPitcherStat();
                $stats->player_id = $player->id;
                $stats->team_id = 0;
                $stats->game_id = 0;
                $stats->name = null;
                $stats->jersey = null;
                $stats->active = 0;
                $stats->IP = 0;
                $stats->H = 0;
                $stats->R = 0;
                $stats->ERR = 0;
                $stats->BB = 0;
                $stats->SO = 0;
                $stats->HR = 0;
                $stats->PC = 0;
                $stats->ST = 0;
                $stats->ERA = 0;
                $blankStats[] = $stats;
            }
        }
        
        return $blankStats;
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
        $query->leftjoin('games', 'games.id', '=', 'player_softball_pitcher_stats.game_id');
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
    
     private function filterByPlayerId($query, $playerId) {
         
        if (isset($playerId) && $playerId !== '' && $playerId !== false) {
            $query->where('player_softball_pitcher_stats.player_id', '=', $playerId);
        }
        
        return $query;
    }
    
     private function filterByTeamId($query, $teamId) {
        if (isset($teamId) && $teamId !== '' && $teamId !== false) {
            $query->where('player_softball_pitcher_stats.team_id', '=', $teamId);
        }
        
        return $query;
    }
    
    private function filterByActive($query, $active) {
         
        if (isset($active) && $active !== '' && $active !== false) {
            $query->where('player_softball_pitcher_stats.active', '=', $active);
        }
        
        return $query;
    }
    
    private function filterByScored($stats) {
        $scoredGameStats = [];
        foreach ($stats as $stat) {
            $scoredGameStats[] = $stat;
            $homeTeamStats = $stat->game->homeTeam->stats()->where('game_id', '=', $stat->game->id)->get();
            
            if ($homeTeamStats->count()) {
                $gameStats = $homeTeamStats->first();
                $isScored = $gameStats->win + $gameStats->loss + $gameStats->draw;
                if ($isScored) {
                $scoredGameStats[] = $stat;
                }
            }
        }
        
        return collect($scoredGameStats);
    }
    
    private function paginatePlayerStats($total, $limit) 
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

