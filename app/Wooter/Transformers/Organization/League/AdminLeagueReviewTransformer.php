<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\User;
use Wooter\LeagueOrganization;
use Wooter\LeagueReview;
use Wooter\Organization;
use Wooter\Wooter\Transformers\Transformer;

class AdminLeagueReviewTransformer extends Transformer
{
    public function transform($data, $multiple = false) {

        $return = [];

        if($multiple){
            foreach ($data as $item){
                $return[] = $this->render($item);
            }
        } else {
            $return = $this->render($data);
        }

        return $return;
    }

    private function render ($item) {
        $item = LeagueReview::where('id', $item->id)->first();
        $user = User::where('id', $item->reviewer_id)->first();
        $leagueOrganization = LeagueOrganization::where('id', $item->league_id)->first();

        return [
            'id' => $item->id,
            'review'=>$item->review,
            'league_id'=>$leagueOrganization->id,
            'league_name'=>$leagueOrganization->name,
            'reviewer_id'=>$user->id,
            'reviewer_name'=>$user->first_name,
            // 'organization_id'=>$leagueOrganization->id,
            // 'organization_name'=>$leagueOrganization->name,
            'created_at'=>$item->created_at,
            'updated_at'=>$item->updated_at
        ];
    }
}
