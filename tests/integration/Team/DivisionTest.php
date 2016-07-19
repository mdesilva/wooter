<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\Division;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;

class DivisionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_division()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $name = $this->faker->name;

        $data = [
            'name' => $name,
            'league_id' => $league->id,
        ];

        $this->post('api/divisions', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $division = Division::whereId($result['data']['id'])->first();
        $this->assertEquals($result['data']['name'], $division->name);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['stage_id'], $league->fresh()->seasons()->first()->regular_stages()->first()->id);
    }

    /**
     * @test
     */
    public function it_edits_a_division()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $division = factory(Division::class)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id, 'stage_type' => RegularStage::class]);

        $newName = $this->faker->name;

        $data = [
            'name' => $newName
        ];

        $this->put('api/divisions/' . $division->id, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $division = $division->fresh();
        $this->assertEquals($result['data']['name'], $division->name);
        $this->assertEquals($result['data']['stage_id'], $league->fresh()->seasons()->first()->regular_stages()->first()->id);
        $this->assertEquals($result['data']['name'], $newName);
    }

    /**
     * @test
     */
    public function it_deletes_a_division()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $division = factory(Division::class)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id, 'stage_type' => RegularStage::class]);

        $this->delete('api/divisions/' . $division->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data'], 'Deleted successfully');
        $this->assertNull($division->fresh());
    }

    /**
     * @test
     */
    public function it_reads_a_division()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $division = factory(Division::class)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id, 'stage_type' => RegularStage::class]);

        $this->get('api/divisions/' . $division->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $division = $division->fresh();
        $this->assertEquals($result['data']['name'], $division->name);
        $this->assertEquals($result['data']['stage_id'], $league->fresh()->seasons()->first()->regular_stages()->first()->id);
    }
}
