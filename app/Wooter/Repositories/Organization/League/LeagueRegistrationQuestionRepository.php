<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use Wooter\LeagueRegistrationQuestion;

class LeagueRegistrationQuestionRepository
{

    public function create(LeagueRegistrationQuestion $leagueRegistrationQuestion)
    {
        return $leagueRegistrationQuestion->save();
    }

    public function update(LeagueRegistrationQuestion $leagueRegistrationQuestion)
    {
        return $leagueRegistrationQuestion->save();
    }

    public function getById($leagueRegistrationQuestionId) {
        return LeagueRegistrationQuestion::whereId($leagueRegistrationQuestionId)->first();
    }

    public function getByLeagueIdWithPagination($leagueId)
    {
        return LeagueRegistrationQuestion::whereLeagueId($leagueId)->paginate();
    }
}
