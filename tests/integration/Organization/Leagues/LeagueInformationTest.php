<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueDetails;

class LeagueInformationTest extends TestCase {

    use DatabaseTransactions;

    /**
     * Check if League response are OK
     *
     * @test
     */
    public function it_fetch_league_information () {
        $leagueID = 1;

        $league = LeagueOrganization::find($leagueID);

        if(!is_null($league)){

            $organization = $league->organization()->first();

            $response = [
                'id' => $league->first()->id,
                'name' => $league->first()->name,
                'description' => $league->details()->first()->description,
                'organization' => [
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'email' => $organization->email,
                    'phone' => $organization->phone,
                    'image' => $organization->image,
                    'social' => [
                        'facebook' => $organization->facebook,
                        'twitter' => $organization->twitter,
                        'instagram' => $organization->instagram,
                        'pinterest' => $organization->pinterest,
                        'google' => $organization->google
                    ]
                ]
            ];

        } else {
            $response = false;
        }

        $this->assertFalse(!is_null($league), 'League don\'t exist!');
    }
}
