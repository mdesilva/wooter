<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueGameVenue;
use Wooter\LeagueVideo;
use Wooter\Team;
use Wooter\Video;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class LeagueTeamsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_relates_a_team_with_a_league()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $team = factory(Team::class)->create();

        $data = [
            'team_id' => $team->id
        ];

        $this->post('api/leagues/' . $league->id . '/teams', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data'], 'Success');
        $this->assertEquals($team->fresh()->leagues->first()->id, $league->id);
    }

    /**
     * @test
     */
    public function it_reads_a_team_linked_to_a_league()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $team = factory(Team::class)->create();

        $league->teams()->attach($team->id);

        $this->get('api/leagues/' . $league->id . '/teams/' . $team->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['id'], $team->id);
        $this->assertEquals($result['data']['description'], $team->description);
        $this->assertEquals($result['data']['name'], $team->name);
    }

    /**
     * @test
     */
    public function it_reads_all_teams_for_a_league()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $teams = factory(Team::class, 10)->create();

        foreach ($teams as $team) {
            $league->teams()->attach($team->id);
        }

        $this->get('api/leagues/' . $league->id . '/teams', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertCount(10,$result['data']['teams']);
    }

    /**
     * @test
     */
    public function it_deletes_a_team_linked_to_a_league()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $team = factory(Team::class)->create();

        $league->teams()->attach($team->id);

        $this->delete('api/leagues/' . $league->id . '/teams/' . $team->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data'], 'Successfully Deleted');
        $this->assertCount(0, $league->fresh()->teams);
    }

    /**
     * @test
     */
    public function it_cant_relate_a_team_to_a_league_without_being_league_owner()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $newUserLogged = $this->createAndLoginAnOrganization();

        $team = factory(Team::class)->create();

        $data = [
            'team_id' => $team->id
        ];

        $this->post('api/leagues/' . $league->id . '/teams', $data, $this->getHeaders());

        $this->assertResponseStatus(HTTPStatusCode::FORBIDDEN);
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['error']['message'], 'You do not have permission to perform this action');
    }
}
