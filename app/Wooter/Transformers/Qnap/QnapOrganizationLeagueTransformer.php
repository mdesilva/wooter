<?php

namespace Wooter\Wooter\Transformers\Qnap;

use Wooter\Wooter\Transformers\Transformer;

class QnapOrganizationLeagueTransformer extends Transformer
{
    public function transform($qnapLeagues)
    {

        $organizationLeagues = array();

        foreach($qnapLeagues as $organizationId => $orgLeagues)
        {


            foreach( $orgLeagues as $orgName => $orgLeagues)
            {
                foreach($orgLeagues as $leagueId => $leagueName)
                {
                    $organizationLeagues[$organizationId][$orgName][$leagueId] = $leagueName;
                }
            }



        }

        return $organizationLeagues;
    }
}