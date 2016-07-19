<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use DB;
use Wooter\PlayerBasketballStat;

class LeagueStatsRepository
{

    public function create(PlayerBasketballStat $stat)
    {
        return $stat->save();
    }

    public function update(PlayerBasketballStat $stat)
    {
        return $stat->save();
    }

    public function getById($stat_id) {
        return PlayerBasketballStat::whereId($stat_id)->first();
    }
    
    public function getByLeagueId($league_id) {
        return PlayerBasketballStat::whereHas('league', function($query) use($league_id){
            $query->where('id', '=', $league_id);
        })->get();
    }
    
    public function filterByPlayerId($stats, $player_id) {
        if ($stats->count()) {
                $ids = $stats->lists('id')->toArray();

                return PlayerBasketballStat::whereIn('id', $ids)
                                          ->whereHas('player', function($query) use($player_id) {
                                              $query->where('id', '=', $player_id);
                                          })->get();
        }
        
        return collect([]);
    }
    
    public function filterBySeasonId($stats, $season_id) {
        if ($stats->count()) {
                $ids = $stats->lists('id')->toArray();

                return PlayerBasketballStat::whereIn('id', $ids)
                                          ->whereHas('game', function($query) use($season_id) {
                                              $query->where('season_id', '=', $season_id);
                                          })->get();
        }
        
        return collect([]);
    }
    
    public function filterByTeamId($stats, $team_id) {
        if ($stats->count()) {
                $ids = $stats->lists('id')->toArray();

                return PlayerBasketballStat::whereIn('id', $ids)
                                          ->where('team_id', '=', $team_id)
                                          ->get();
        }
        
        return collect([]);
    }
    
    public function filterByGameId($stats, $game_id) {
        if ($stats->count()) {
                $ids = $stats->lists('id')->toArray();

                return PlayerBasketballStat::whereIn('id', $ids)
                                          ->where('game_id', '=', $game_id)
                                          ->get();
        }
        
        return collect([]);
    }
}
