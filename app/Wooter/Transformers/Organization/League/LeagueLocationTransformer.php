<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\LocationTransformer;
use Wooter\Wooter\Transformers\Transformer;

class LeagueLocationTransformer extends Transformer
{
    /**
     * @var LocationTransformer
     */
    private $locationTransformer;

    /**
     * @param LocationTransformer $locationTransformer
     */
    public function __construct(LocationTransformer $locationTransformer) {

        $this->locationTransformer = $locationTransformer;
    }

    public function transform($leagueLocation) {

        $result = [
            'id' => intval($leagueLocation->id),
            'league_id' => intval($leagueLocation->league_id),
            'location' => $this->locationTransformer->transform($leagueLocation->location)
        ];

        return $result;
    }
}
