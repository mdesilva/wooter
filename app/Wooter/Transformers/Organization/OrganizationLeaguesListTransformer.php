<?php

namespace Wooter\Wooter\Transformers\Organization;

use Wooter\Wooter\Transformers\Transformer;

class OrganizationLeaguesListTransformer extends Transformer {

    /**
     * Transform method
     *
     * @param $leagues
     * @return mixed
     */
    public function transform($leagues) {
        $return = [];

        foreach ($leagues as $league){
            $season = [];

            if(isset($league["seasons"][0])){
                $season = $league["seasons"][0];
                unset($season['league_id']);
            }
            $return[] = [
                "id" => $league['id'],
                "archived" => $league['archived'],
                "name" => $league['name'],
                "season" => $season,
                "image" => ( isset($league["photos"][0]) )?$league["photos"][0]:[]
            ];
        }

        return $return;
    }
}
