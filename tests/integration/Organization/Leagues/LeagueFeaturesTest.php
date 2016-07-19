<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\Feature;
use Wooter\LeagueFeature;
use Wooter\LeagueOrganization;
use Wooter\LeaguePhoto;

class LeaguesLeagueFeaturesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_league_features()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $feature = factory(Feature::class)->create();

        $data = [
            'feature_id' => $feature->id,
        ];

        $this->post('api/leagues/'.$league->id.'/features', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['feature_id'], $feature->id);
        $this->assertEquals($result['data']['name'], $feature->name);
        $this->assertEquals($result['data']['name_localized'], $feature->name_localized);
    }

    /**
     * @test
     */
    public function it_reads_league_features()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $leagueFeatures = factory(LeagueFeature::class, 10)->create(['league_id' => $league->id]);

        $name = $this->faker->name;

        $data = [
            'name' => $name,
        ];

        $this->get('api/leagues/'.$league->id.'/features', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $i = 0;

        foreach ($leagueFeatures as $leagueFeature) {
            $this->assertEquals($result['data'][$i]['name'], $leagueFeature->feature->name);
            $this->assertEquals($result['data'][$i]['name_localized'], $leagueFeature->feature->name_localized);
            $i++;
        }
    }

    /**
     * @test
     */
    public function it_deletes_league_features()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $feature = factory(Feature::class)->create();

        $data = [
            'feature_id' => $feature->id,
        ];

        $this->post('api/leagues/'.$league->id.'/features', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['feature_id'], $feature->id);
        $this->assertEquals($result['data']['name'], $feature->name);
        $this->assertEquals($result['data']['name_localized'], $feature->name_localized);

        $this->delete('api/leagues/'.$league->id.'/features/' . $feature->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data'], 'Success');
        $this->assertNull(LeagueFeature::whereLeagueId($league->id)->whereFeatureId($feature->id)->first());


    }
}
