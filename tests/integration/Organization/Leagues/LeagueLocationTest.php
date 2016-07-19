<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\LeagueLocation;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueGameVenue;
use Wooter\LeagueVideo;
use Wooter\Team;
use Wooter\Video;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class LeagueLocationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_reads_all_league_locations()
    {
        $user = $this->createAndLoginABasicUser();

        $league = factory(LeagueOrganization::class)->create();
        $leagueLocations = factory(LeagueLocation::class, 10)->create(['league_id' => $league->id]);

        $this->get('api/leagues/' . $league->id . '/locations', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertCount(10, $result['data']);

        $i = 0;
        foreach ($leagueLocations as $leagueLocation) {
            $location = $leagueLocation->location;
            $this->assertEquals($result['data'][$i]['league_id'], $league->id);
            $this->assertEquals($result['data'][$i]['location']['id'], $location->id);
            $this->assertEquals($result['data'][$i]['location']['country'], $location->country->name);
            $this->assertEquals($result['data'][$i]['location']['city'], $location->city->name);
            $this->assertEquals($result['data'][$i]['location']['state'], $location->state);
            $this->assertEquals($result['data'][$i]['location']['longitude'], $location->longitude);
            $this->assertEquals($result['data'][$i]['location']['latitude'], $location->latitude);
            $this->assertEquals($result['data'][$i]['location']['name'], $location->name);
            $this->assertEquals($result['data'][$i]['location']['street'], $location->street);
            $this->assertEquals($result['data'][$i]['location']['zip'], $location->zip);
            $this->assertEquals($result['data'][$i]['location']['full_address'], $location->full_address);
            $this->assertEquals($result['data'][$i]['location']['flat'], $location->flat);

            $i++;
        }
    }

}
