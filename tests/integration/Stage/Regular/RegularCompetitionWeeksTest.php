<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\CompetitionWeek;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueGameVenue;
use Wooter\LeagueVideo;
use Wooter\Team;
use Wooter\Video;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class RegularCompetitionWeeksTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_regular_competition_week()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $startsAt = $this->faker->date();
        $endsAt = $this->faker->date();
        $name = $this->faker->firstName;

        $data = [
            'name' => $name,
            'ends_at' => $endsAt,
            'starts_at' => $startsAt,
        ];

        $this->post('api/regulars/' . $league->seasons()->first()->regular_stages()->first()->id . '/competition-weeks', $data, $this->getHeaders());
        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['ends_at']['date'], $endsAt . ' 00:00:00.000000');
        $this->assertEquals($result['data']['starts_at']['date'], $startsAt . ' 00:00:00.000000');
    }

    /**
     * @test
     */
    public function it_reads_the_competition_weeks_for_a_regular_stage()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $competitionWeeks = factory(CompetitionWeek::class, 10)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id]);

        $this->get('api/regulars/' . $league->seasons()->first()->regular_stages()->first()->id . '/competition-weeks', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $i = 0;
        foreach ($competitionWeeks as $competitionWeek) {
            $this->assertEquals($result['data'][$i]['name'], $competitionWeek->name);
            $this->assertEquals($result['data'][$i]['ends_at']['date'], $competitionWeek->ends_at . '.000000');
            $this->assertEquals($result['data'][$i]['starts_at']['date'], $competitionWeek->starts_at . '.000000');

            $i++;
        }
    }

    /**
     * @test
     */
    public function it_deletes_a_competition_week_for_a_stage()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeagueAndSeason();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $competitionWeek = factory(CompetitionWeek::class)->create(['stage_id' => $league->seasons()->first()->regular_stages()->first()->id]);

        $this->delete('api/regulars/' . $league->seasons()->first()->regular_stages()->first()->id . '/competition-weeks/' . $competitionWeek->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data'], 'Success');
        $this->assertNull($competitionWeek->fresh());
    }

}
