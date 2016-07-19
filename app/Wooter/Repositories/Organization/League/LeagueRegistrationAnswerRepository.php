<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use Wooter\LeagueRegistrationAnswer;

class LeagueRegistrationAnswerRepository
{

    public function create(LeagueRegistrationAnswer $leagueRegistrationAnswer)
    {
        return $leagueRegistrationAnswer->save();
    }

    public function update(LeagueRegistrationAnswer $leagueRegistrationAnswer)
    {
        return $leagueRegistrationAnswer->save();
    }

    public function getById($leagueRegistrationAnswerId) {
        return LeagueRegistrationAnswer::whereId($leagueRegistrationAnswerId)->first();
    }

    public function getByLeagueIdWithPagination($leagueId)
    {
        return LeagueRegistrationAnswer::whereLeagueId($leagueId)->paginate();
    }
    
    public function filterByLeagueId($answers, $leagueId) 
    {
        if ($answers->count()) {
            $ids = $answers->lists('id')->toArray();
            
            return LeagueRegistrationAnswer::whereIn('id', $ids)
                                           ->where('league_id', '=', $leagueId)
                                           ->get();
        }
        
        return $answers;
    }
    
    public function filterByPlayerId($answers, $playerId)
    {
        if ($answers->count()) {
            $ids = $answers->lists('id')->toArray();
            
            return LeagueRegistrationAnswer::whereIn('id', $ids)
                                           ->where('user_id', '=', $playerId)
                                           ->get();
        }
        
        return $answers;
    }
}
