<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueGameVenue;
use Wooter\LeagueSeason;
use Wooter\SeasonCompetition;
use Wooter\Sport;

class LeagueSeasonTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_league_season_basic()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeagueAndSeason();
    }

    /**
     * @test
     */
    public function it_edits_a_league_season_basic()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $leagueSeason = $league->seasons->first();

        $name = $this->faker->name;
        $startsAt = $this->faker->date();
        $endsAt = $this->faker->date();
        $opensAt = $this->faker->date();
        $closesAt = $this->faker->date();
        $maxTeams = $this->faker->numberBetween(5, 100);
        $maxFreeAgents = $this->faker->numberBetween(5, 100);
        $minTeams = $this->faker->numberBetween(2, 5);
        $minFreeAgents = $this->faker->numberBetween(2, 5);

        $data = [
            'name' => $name,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'registration_opens_at' => $opensAt,
            'registration_closes_at' => $closesAt,
            'max_teams' => $maxTeams,
            'max_free_agents' => $maxFreeAgents,
            'min_teams' => $minTeams,
            'min_free_agents' => $minFreeAgents,
        ];

        $this->put('api/leagues/' . $leagueId .'/seasons/' . $leagueSeason->id , $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['starts_at'], $startsAt);
        $this->assertEquals($result['data']['ends_at'], $endsAt);
        $this->assertEquals($result['data']['registration_opens_at'], $opensAt);
        $this->assertEquals($result['data']['registration_closes_at'], $closesAt);
        $this->assertEquals($result['data']['max_teams'], $maxTeams);
        $this->assertEquals($result['data']['max_free_agents'], $maxFreeAgents);
        $this->assertEquals($result['data']['min_teams'], $minTeams);
        $this->assertEquals($result['data']['min_free_agents'], $minFreeAgents);
    }

    /**
     * @test
     */
    public function it_deletes_a_league_season()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeague();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $leagueSeason = $league->seasons->first();

        $this->delete('api/leagues/' . $leagueId . '/seasons/' . $leagueSeason->id, [], $this->getHeaders());

        $league = LeagueOrganization::whereId($leagueId)->first();

        $this->assertNull($league->seasons->first());
    }

    /**
     * @test
     */
    public function it_reads_all_league_seasons()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $leagueSeasons = SeasonCompetition::whereOrganizationId($leagueId)->whereOrganizationType(LeagueOrganization::class)->get();

        $this->get('api/leagues/'.$leagueId.'/seasons', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $i = 0;
        foreach ($leagueSeasons as $leagueSeason) {
            $this->assertEquals($result['data'][$i]['name'], $leagueSeason->name);
            $this->assertEquals($result['data'][$i]['starts_at'], $leagueSeason->starts_at);
            $this->assertEquals($result['data'][$i]['ends_at'], $leagueSeason->ends_at);
            $this->assertEquals($result['data'][$i]['registration_opens_at'], $leagueSeason->registration_opens_at);
            $this->assertEquals($result['data'][$i]['registration_closes_at'], $leagueSeason->registration_closes_at);
            $this->assertEquals($result['data'][$i]['max_teams'], $leagueSeason->max_teams);
            $this->assertEquals($result['data'][$i]['max_free_agents'], $leagueSeason->max_free_agents);

            $i++;
        }
    }

    /**
     * @test
     */
    public function it_read_a_league_season()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $season = $league->seasons->first();

        $this->get('api/leagues/'.$leagueId.'/seasons/' . $season->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['name'], $season->name);
        $this->assertEquals($result['data']['starts_at'], $season->starts_at);
        $this->assertEquals($result['data']['ends_at'], $season->ends_at);
        $this->assertEquals($result['data']['registration_opens_at'], $season->registration_opens_at);
        $this->assertEquals($result['data']['registration_closes_at'], $season->registration_closes_at);
        $this->assertEquals($result['data']['max_teams'], $season->max_teams);
        $this->assertEquals($result['data']['max_free_agents'], $season->max_free_agents);
    }
}
