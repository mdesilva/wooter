<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Wooter\Game;
use Wooter\GameVenue;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueDetails;
use Wooter\RegularStage;
use Wooter\Sport;
use Wooter\Team;

class GamesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_game()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeague();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $homeTeam = factory(Team::class)->create();
        $visitingTeam = factory(Team::class)->create();
        $gameVenue = factory(GameVenue::class)->create();
        $time = new Carbon\Carbon();
        $data = [
            'home_team_id' => $homeTeam->id,
            'visiting_team_id' => $visitingTeam->id,
            'sport_id' => Sport::BASKETBALL,
            'stage_id' => $league->season_competitions->first()->regular_stages->first()->id,
            'game_venue_id' => $gameVenue->id,
            'stage_type' => RegularStage::class,
            'time' => $time,
        ];

        $this->post('api/games', $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['home_team_id'], $homeTeam->id);
        $this->assertEquals($result['data']['visiting_team_id'], $visitingTeam->id);
        $this->assertEquals($result['data']['sport'], 'Basketball');
        $this->assertEquals($result['data']['game_venue']['id'], $gameVenue->id);
        $this->assertEquals($result['data']['stage_id'], $league->season_competitions->first()->regular_stages->first()->id);
        $this->assertEquals($result['data']['stage_type'], RegularStage::class);
        $this->assertEquals($result['data']['time']['date'], $time->toDateTimeString() . '.000000');

        return $league->id;
    }

    /**
     * @test
     */
    public function it_edits_a_game()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeague();

        $league = LeagueOrganization::whereId($leagueId)->first();
        $stageId = $league->season_competitions->first()->regular_stages->first()->id;

        $game = factory(Game::class)->create(['stage_id' => $stageId, 'stage_type' => RegularStage::class]);

        $time = new Carbon\Carbon();
        $homeTeam = factory(Team::class)->create();
        $visitingTeam = factory(Team::class)->create();
        $gameVenue = factory(GameVenue::class)->create();
        $data = [
            'home_team_id' => $homeTeam->id,
            'visiting_team_id' => $visitingTeam->id,
            'sport_id' => Sport::BASKETBALL,
            'stage_id' => $stageId,
            'game_venue_id' => $gameVenue->id,
            'stage_type' => RegularStage::class,
            'time' => $time,
        ];

        $this->put('api/games/' . $game->id, $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['home_team_id'], $homeTeam->id);
        $this->assertEquals($result['data']['visiting_team_id'], $visitingTeam->id);
        $this->assertEquals($result['data']['sport'], 'Basketball');
        $this->assertEquals($result['data']['game_venue']['id'], $gameVenue->id);
        $this->assertEquals($result['data']['stage_id'], $league->season_competitions->first()->regular_stages->first()->id);
        $this->assertEquals($result['data']['stage_type'], RegularStage::class);
        $this->assertEquals($result['data']['time']['date'], $time->toDateTimeString() . '.000000');

        return $league->id;
    }

    /**
     * @test
     */
    public function it_reads_a_game()
    {
        $this->createAndLoginAnOrganization();
        $leagueId = $this->createLeague();

        $league = LeagueOrganization::whereId($leagueId)->first();
        $stageId = $league->season_competitions->first()->regular_stages->first()->id;

        $game = factory(Game::class)->create(['stage_id' => $stageId, 'stage_type' => RegularStage::class]);

        $this->get('api/games/' . $game->id, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['home_team_id'], $game->home_team_id);
        $this->assertEquals($result['data']['visiting_team_id'], $game->visiting_team_id);
        $this->assertEquals($result['data']['sport'], $game->sport->name);
        $this->assertEquals($result['data']['game_venue']['id'], $game->game_venue->id);
        $this->assertEquals($result['data']['stage_id'], $stageId);
        $this->assertEquals($result['data']['stage_type'], RegularStage::class);
        $this->assertEquals($result['data']['time']['date'], $game->time->toDateTimeString() . '.000000');
    }
}
