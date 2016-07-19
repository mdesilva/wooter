<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueDetails;

class LeagueDetailsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_the_league_details()
    {
        $this->createLeagueAndItsDetails();
    }

    private function createLeagueAndItsDetails()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $maxPlayers = 25;
        $gameDuration = 90;
        $gamesPerTeam = 38;

        $data = [
            'number_of_teams'=> 20,
            'players_per_team'=> 11,
            'games_per_team'=> $gamesPerTeam,
            'max_players'=> $maxPlayers,
            'game_duration'=> $gameDuration,
            'time_period'=> 45,
            'description' => 'Best league ever'
        ];

        $this->post('api/leagues/' . $league->id . '/details', $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['max_players'], $maxPlayers);
        $this->assertEquals($result['data']['game_duration'], $gameDuration);
        $this->assertEquals($result['data']['games_per_team'], $gamesPerTeam);

        return $league->id;
    }

    /**
     * @test
     */
    public function it_edits_the_league_details()
    {
        $leagueId = $this->createLeagueAndItsDetails();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $maxPlayers = 30;
        $gameDuration = 120;
        $gamesPerTeam = 40;

        $this->put('api/leagues/' . $league->id . '/details', [
            'number_of_teams'=> 20,
            'players_per_team'=> 11,
            'games_per_team'=> $gamesPerTeam,
            'max_players'=> $maxPlayers,
            'game_duration'=> $gameDuration,
            'time_period'=> 45,
            'description' => 'Best league ever'
        ], $this->headers);

        $league = LeagueOrganization::whereId($league->id)->first();

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['games_per_team'], $gamesPerTeam);
        $this->assertEquals($result['data']['max_players'], $maxPlayers);
        $this->assertEquals($result['data']['game_duration'], $gameDuration);
        $this->assertEquals($result['data']['players_per_team'], 11);
        $this->assertEquals($league->details->games_per_team, $gamesPerTeam);
        $this->assertEquals($league->details->max_players, $maxPlayers);
        $this->assertEquals($league->details->game_duration, $gameDuration);
    }

    /**
     * @test
     */
    public function it_reads_the_league_details()
    {
        $leagueId = $this->createLeagueAndItsDetails();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $this->get('api/leagues/' . $league->id . '/details', $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $leagueDetails = json_decode($this->response->content(), true);

        $this->assertEquals($leagueDetails['data']['games_per_team'], 38);
        $this->assertEquals($leagueDetails['data']['game_duration'], 90);
        $this->assertEquals($leagueDetails['data']['league_id'], $leagueId);
    }
}
