<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\User\UserTransformer;

class LeagueReviewTransformer extends Transformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * @param UserTransformer $userTransformer
     */
    public function __construct(UserTransformer $userTransformer)
    {

        $this->userTransformer = $userTransformer;
    }

    public function transform($leagueReview)
    {
        return [
            'id' => $leagueReview->id,
            'review' => $leagueReview->review,
            'reviewer_id' => $leagueReview->reviewer_id,
            'reviewer' => $this->userTransformer->transform($leagueReview->reviewer),
            'verified' => $leagueReview->verified,
            'stars' => $leagueReview->stars,
        ];
    }
}
