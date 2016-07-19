<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\Division;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\Team;
use Wooter\TeamDivision;

class DivisionTeamTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_division_team()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $division = factory(Division::class)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id, 'stage_type' => RegularStage::class]);
        $team = factory(Team::class)->create();

        $data = [
            'teams' => [$team->id],
        ];

        $this->post('api/divisions/'.$division->id.'/teams', $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data'], 'Success');
    }

    /**
     * @test
     */
    public function it_reads_a_team_division()
    {
        $user = $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $division = factory(Division::class)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id, 'stage_type' => RegularStage::class]);
        $division->teams()->attach(factory(Team::class)->create()->id);

        $this->get('api/divisions/'.$division->id.'/teams', $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
    }
}
