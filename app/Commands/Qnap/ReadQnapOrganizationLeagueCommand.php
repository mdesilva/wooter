<?php

namespace Wooter\Commands\Qnap;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Organization;

class ReadQnapOrganizationLeagueCommand extends Command implements SelfHandling
{



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @return array
     */
    public function handle()
    {


        $organizationLeagues = array();

        $organizations = Organization::all();



        foreach($organizations as $organization)
        {
            $leagues = $organization->leagues()->where('active',1)->get();

            if( count($leagues) > 0 )
            {
                   foreach($leagues as $league)
                   {
                       $organizationLeagues[$organization->id][$organization->name][$league->id] = $league->name;

                   }
            }



        }


       return $organizationLeagues;
    }
}
