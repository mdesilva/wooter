<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueDetails;
use Wooter\LeagueLocation;
use Wooter\Location;
use Wooter\Sport;
use Wooter\Wooter\Contracts\HTTPStatusCode;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;

class LeagueTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     * @test
     */
    public function it_creates_a_new_league()
    {
        $user = $this->createAndLoginAnOrganization();
        $this->createLeague();

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['name'], 'Liga de Fútbol Profesional Española');
    }

    /**
     * @test
     */
    public function unauthorized_to_create_a_league_as_a_player()
    {
        $this->createAndLoginABasicUser();

        $data = [
            'name' => 'Liga de Fútbol Profesional Española',
            'sport_id' => Sport::FOOTBALL
        ];

        $this->post('api/leagues', $data, $this->headers);

        $leagueData = json_decode($this->response->content(), true);

        $this->assertResponseStatus(HTTPStatusCode::UNAUTHORIZED);
        $this->assertEquals($leagueData['error']['message'], 'Not Authorized!');
        $this->assertEquals($leagueData['error']['status_code'], HTTPStatusCode::UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_edits_one_league()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();
        $newLeagueName = $this->faker->name;

        $data = [
            'name' => $newLeagueName,
            'sport_id' => Sport::SOCCER
        ];

        $this->put('api/leagues/' . $league->id, $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();

        $result = json_decode($this->response->content(), true);

        $this->assertEquals($result['data']['name'], $newLeagueName);
        $this->assertEquals($result['data']['id'], $league->id);
        $this->assertEquals($result['data']['sport_id'], Sport::SOCCER);

        $leagueUpdated = LeagueOrganization::whereId($league->id)->first();

        $this->assertEquals($newLeagueName, $leagueUpdated->name);
        $this->assertEquals($league->id, $leagueUpdated->id);
    }

    /**
     * @test
     */
    public function it_deletes_a_league()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();
        $leagueId = $league->id;

        $this->assertInstanceOf(LeagueOrganization::class, $league);
        $this->delete('api/leagues/' . $leagueId, [], $this->headers);

        $this->seeStatusCode(500);

    }

    /**
     * @test
     */
    public function it_reads_one_league()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $this->get('api/leagues/' . $league->id);

        $leagueData = json_decode($this->response->content(), true);

        $this->assertResponseOk();
        $this->assertEquals($leagueData['data']['name'], 'Liga de Fútbol Profesional Española');
        $this->assertEquals($leagueData['data']['id'], $league->id);
    }

    /**
     * @test
     */
    public function a_league_was_not_found()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $this->get('api/leagues/' . $this->faker->randomDigit);

        $leagueData = json_decode($this->response->content(), true);

        $this->assertResponseStatus(HTTPStatusCode::NOT_FOUND);
        $this->assertEquals($leagueData['error']['message'], (new LeagueNotFound)->getMessage());
        $this->assertEquals($leagueData['error']['status_code'], HTTPStatusCode::NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_searches_leagues_by_min_age()
    {
        $this->createAndLoginABasicUser();

        $minAge = 15;

        $leagueBasics = factory(LeagueBasics::class)->create(['min_age' => $minAge]);

        $this->get('api/leagues?min_age=' . $minAge, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['data'][0]['basics']['min_age'], $minAge);

    }

    /**
     * @test
     */
    public function it_searches_leagues_by_max_age()
    {
        $this->createAndLoginABasicUser();

        $maxAge = 40;

        $leagueBasics = factory(LeagueBasics::class)->create(['max_age' => $maxAge]);

        $this->get('api/leagues', $this->getHeaders());
        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['data'][0]['basics']['max_age'], $maxAge);

    }

    /**
     * @test
     */
    public function it_searches_leagues_by_max_gender()
    {
        $this->createAndLoginABasicUser();

        $gender = 'male';

        $leagueBasics = factory(LeagueBasics::class)->create(['gender' => $gender]);

        $this->get('api/leagues', $this->getHeaders());
        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['data'][0]['basics']['gender'], $gender);

    }

    /**
     * @test
     */
    public function it_searches_leagues_and_check_details()
    {
        $this->createAndLoginABasicUser();

        $name = 'Ligaca';

        $league = factory(LeagueOrganization::class)->create(['name' => $name]);
        factory(LeagueBasics::class)->create(['league_id' => $league->id]);

        $numberOfTeams = $this->faker->numberBetween(20,30);
        $playersPerTeam = $this->faker->numberBetween(20,30);
        $gamesPerTeam = $this->faker->numberBetween(20,30);
        $maxPlayers = $this->faker->numberBetween(20,30);
        $gameDuration = $this->faker->numberBetween(90,120);
        $timeDuration = $this->faker->numberBetween(90,120);

        factory(LeagueDetails::class)->create([
            'league_id' => $league->id,
            'number_of_teams' => $numberOfTeams,
            'players_per_team' => $playersPerTeam,
            'games_per_team' => $gamesPerTeam,
            'max_players' => $maxPlayers,
            'game_duration' => $gameDuration,
            'time_period' => $timeDuration,
        ]);

        $this->get('api/leagues', $this->getHeaders());
        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['data'][0]['details']['number_of_teams'], $numberOfTeams);
        $this->assertSame($result['data'][0]['details']['players_per_team'], $playersPerTeam);
        $this->assertSame($result['data'][0]['details']['games_per_team'], $gamesPerTeam);
        $this->assertSame($result['data'][0]['details']['max_players'], $maxPlayers);
        $this->assertSame($result['data'][0]['details']['game_duration'], $gameDuration);
        $this->assertSame($result['data'][0]['details']['time_period'], $timeDuration);
    }

    /**
     * @test
     */
    public function it_fetches_a_league_and_check_details()
    {
        $this->createAndLoginABasicUser();

        $name = 'Ligaca';
        $league = factory(LeagueOrganization::class)->create(['name' => $name]);
        factory(LeagueBasics::class)->create(['league_id' => $league->id]);

        $numberOfTeams = $this->faker->numberBetween(20,30);
        $playersPerTeam = $this->faker->numberBetween(20,30);
        $gamesPerTeam = $this->faker->numberBetween(20,30);
        $maxPlayers = $this->faker->numberBetween(20,30);
        $gameDuration = $this->faker->numberBetween(90,120);
        $timeDuration = $this->faker->numberBetween(90,120);

        factory(LeagueDetails::class)->create([
            'league_id' => $league->id,
            'number_of_teams' => $numberOfTeams,
            'players_per_team' => $playersPerTeam,
            'games_per_team' => $gamesPerTeam,
            'max_players' => $maxPlayers,
            'game_duration' => $gameDuration,
            'time_period' => $timeDuration,
        ]);

        $this->get('api/leagues', $this->getHeaders());
        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['data'][0]['details']['number_of_teams'], $numberOfTeams);
        $this->assertSame($result['data'][0]['details']['players_per_team'], $playersPerTeam);
        $this->assertSame($result['data'][0]['details']['games_per_team'], $gamesPerTeam);
        $this->assertSame($result['data'][0]['details']['max_players'], $maxPlayers);
        $this->assertSame($result['data'][0]['details']['game_duration'], $gameDuration);
        $this->assertSame($result['data'][0]['details']['time_period'], $timeDuration);
    }

    /**
     * @test
     */
    public function it_fetches_leagues_and_check_inner_data()
    {
        $this->createAndLoginABasicUser();

        $name = 'Ligaca';
        $leagues = factory(LeagueOrganization::class, 10)->create();
        foreach ($leagues as $league) {
            factory(LeagueBasics::class)->create(['league_id' => $league->id]);
            factory(LeagueDetails::class)->create(['league_id' => $league->id]);
        }

        $this->get('api/leagues', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertCount(10,$result['data']);
    }

    /**
     * @test
     */
    public function it_searches_leagues_based_on_distance()
    {
        $this->createAndLoginABasicUser();

        $longitude = 20;
        $latitude = 20;

        $league = factory(LeagueOrganization::class)->create();
        $location = factory(Location::class)->create(['longitude' => $longitude, 'latitude' => $latitude]);

        $leagueLocation = factory(LeagueLocation::class)->create(['league_id' => $league->id , 'location_id' => $location->id]);

        $this->get('api/leagues?longitude=20.20&latitude=20.20&distance=100', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data'][0]['id'], $league->id);


    }

    /**
     * @test
     */
    public function it_creates_many_locations_and_search_by_one_of_them()
    {
        $this->createAndLoginABasicUser();

        $longitude = 20;
        $latitude = 20;

        $league = factory(LeagueOrganization::class)->create();

        $location = factory(Location::class)->create(['longitude' => $longitude, 'latitude' => $latitude]);
        factory(LeagueLocation::class)->create(['league_id' => $league->id , 'location_id' => $location->id]);

        factory(LeagueLocation::class,3)->create(['league_id' => $league->id]);

        $this->get('api/leagues?longitude=20.20&latitude=20.20&distance=100', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data'][0]['id'], $league->id);

        $this->assertCount(4, $league->locations);
    }

    // @todo add tests for search that assure that is possible to have a ?q get param
    // @todo add tests for search that assure that is possible to have a ?order param
    // @todo add tests for search that assure that is possible to have a ?sort param
    // @todo add tests for search that assure that is possible to have a ?filter param
}
