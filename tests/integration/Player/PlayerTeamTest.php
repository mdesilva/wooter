<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Wooter\PlayerLeague;
use Wooter\LeagueOrganization;
use Wooter\PlayerTeam;
use Wooter\Stat;
use Wooter\Role;
use Wooter\Team;
use Wooter\User;
use Wooter\UserRole;

class PlayerTeamTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_an_player_team()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeague();

        $player = factory(User::class)->create();
        $team = factory(Team::class)->create();

        $data = [
            'team_id' => $team->id,
            'league_id' => $leagueId
        ];

        $this->post('api/players/' . $player->id . '/teams', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['id'], $team->id);
        $this->assertEquals($result['data']['name'], $team->name);
    }

    /**
     * @test
     */
    public function it_edits_a_player_team()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeague();

        $player = factory(User::class)->create();
        $team = factory(Team::class)->create();

        $data = [
            'team_id' => $team->id,
            'league_id' => $leagueId
        ];

        $this->post('api/players/' . $player->id . '/teams', $data, $this->getHeaders());

        $newJersey = $this->faker->numberBetween(1,999);

        $data = [
            'jersey' => $newJersey,
            'league_id' => $leagueId,
        ];

        $this->put('api/players/' . $player->id . '/teams/' . $team->id, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();

        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['id'], $player->id);
    }

    /**
     * @test
     */
    public function it_reads_a_player_team()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeague();

        $player = factory(User::class)->create();
        $team = factory(Team::class)->create();

        $data = [
            'team_id' => $team->id,
            'league_id' => $leagueId
        ];

        $this->post('api/players/' . $player->id . '/teams', $data, $this->getHeaders());


        $this->get('api/players/' . $player->id . '/teams/' .  $team->id, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['id'], $team->id);
    }
}
