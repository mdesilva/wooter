<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use Wooter\LeagueOrganization;
use Wooter\LeagueReview;

class LeagueReviewRepository
{

    public function create(LeagueReview $leagueReview)
    {
        return $leagueReview->save();
    }

    public function update(LeagueReview $leagueReview)
    {
        return $leagueReview->save();
    }

    public function getById($leagueReviewId) {
        return LeagueReview::whereId($leagueReviewId)->first();
    }

    public function all()
    {
        return LeagueReview::all();
    }

    public function getByLeagueIdAndFilters($leagueId, $offset, $limit, $orderBy, $orderDirection)
    {
        return LeagueReview::whereLeagueId($leagueId)
            ->orderBy($orderBy, $orderDirection)
            ->get()
            ->slice($offset, $limit);
    }
}
