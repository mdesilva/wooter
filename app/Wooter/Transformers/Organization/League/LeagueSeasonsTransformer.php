<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Stage\Regular\RegularStagesTransformer;
use Wooter\Wooter\Transformers\Transformer;

class LeagueSeasonsTransformer extends Transformer
{
    /**
     * @var RegularStagesTransformer
     */
    private $regularStagesTransformer;

    /**
     * @param RegularStagesTransformer $regularStagesTransformer
     */
    public function __construct(RegularStagesTransformer $regularStagesTransformer)
    {

        $this->regularStagesTransformer = $regularStagesTransformer;
    }

    public function transform($season)
    {
        $season = [
            'id' => $season->id,
            'organization_id' => $season->organization->id,
            'organization_type' => $season->organization_type,
            'name' => $season->name,
            'starts_at' => $season->starts_at,
            'ends_at' => $season->ends_at,
            'registration_opens_at' => $season->registration_opens_at,
            'registration_closes_at' => $season->registration_closes_at,
            'min_teams' => $season->min_teams,
            'max_teams' => $season->max_teams,
            'min_free_agents' => $season->min_free_agents,
            'max_free_agents' => $season->max_free_agents,
            'price' => $season->price,
            'regulars' => $this->regularStagesTransformer->transformCollection($season->regular_stages)
        ];
        
        return $season;
    }
}
