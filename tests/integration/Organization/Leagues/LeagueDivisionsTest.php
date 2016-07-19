<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\LeagueOrganization;
use Wooter\Division;
use Wooter\RegularStage;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class LeagueDivisionsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_relates_a_division_with_a_league()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $name = $this->faker->name;

        $data = [
            'name' => $name
        ];

        $this->post('api/leagues/' . $leagueId . '/divisions', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['name'], $name);

        $league = LeagueOrganization::whereId($leagueId)->first();

        $this->assertEquals($league->seasons()->first()->regular_stages()->first()->id, $result['data']['stage_id']);
        $this->assertEquals(RegularStage::class, $result['data']['stage_type']);
    }

    /**
     * @test
     */
    public function it_reads_a_division_linked_to_a_league()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $division = factory(Division::class)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id, 'stage_type' => RegularStage::class]);

        $this->get('api/leagues/' . $league->id . '/divisions/' . $division->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['id'], $division->id);
        $this->assertEquals($result['data']['name'], $division->name);
        $this->assertEquals($result['data']['stage_id'], $division->stage_id);
    }

    /**
     * @test
     */
    public function it_reads_all_divisions_for_a_league()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();
        $divisions = factory(Division::class)->times(10)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id, 'stage_type' => RegularStage::class]);

        $this->get('api/leagues/' . $league->id . '/divisions?order_direction=asc', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertCount(10,$result['data']);

        $i = 0;
        foreach ($divisions as $division) {
            $this->assertEquals($result['data'][$i]['id'], $division->id);
            $this->assertEquals($result['data'][$i]['name'], $division->name);
            $this->assertEquals($result['data'][$i]['stage_id'], $division->stage_id);
            $i++;
        }

    }

    /**
     * @test
     */
    public function it_deletes_a_division_linked_to_a_league()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $division = factory(Division::class)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id, 'stage_type' => RegularStage::class]);

        $this->assertCount(1, $league->fresh()->season_competitions()->first()->regular_stages()->first()->divisions);
        $this->delete('api/leagues/' . $league->id . '/divisions/' . $division->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data'], 'Successfully Deleted');
        $this->assertCount(0, $league->fresh()->season_competitions()->first()->regular_stages()->first()->divisions);
    }

    /**
     * @test
     */
    public function it_cant_relate_a_division_to_a_league_without_being_league_owner()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $newUserLogged = $this->createAndLoginAnOrganization();

        $division = factory(Division::class)->create();

        $name = $this->faker->name;

        $data = [
            'name' => $name
        ];

        $this->post('api/leagues/' . $league->id . '/divisions', $data, $this->getHeaders());

        $this->assertResponseStatus(HTTPStatusCode::FORBIDDEN);
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['error']['message'], 'You do not have permission to perform this action');
    }
}
