<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\City;
use Wooter\Feature;
use Wooter\GameStructure;
use Wooter\GameVenue;
use Wooter\LeagueOrganization;
use Wooter\LeagueGameVenue;

class FeaturesTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     */
    public function it_gets_all_features()
    {
        $user = $this->createAndLoginABasicUser();

        $features = Feature::all();

        $this->get('api/features', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $i = 0;
        foreach ($features as $feature) {
            $this->assertSame($result['data'][$i]['id'], $feature->id);
            $this->assertSame($result['data'][$i]['name'], $feature->name);
            $this->assertSame($result['data'][$i]['name_localized'], $feature->name_localized);
            $i++;
        }

    }
}