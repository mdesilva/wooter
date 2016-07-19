<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\BasketballGameStats;
use Wooter\FootballGameStats;
use Wooter\Game;
use Wooter\LeagueOrganization;
use Wooter\PlayerBasketballStat;
use Wooter\PlayerTeam;
use Wooter\RegularStage;
use Wooter\Team;

class LeagueGameTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_gets_last_game_id () {
        $user = $this->createAndLoginABasicUser();

        $stage = factory(RegularStage::class)->create();

        $game = factory(Game::class)->create(['stage_id' => $stage->id, 'created_at' => 1]);

        $this->get('api/leagues/' . $game->stage->competition->organization->id . '/games?order_by=created_at&order_direction=desc&limit=1', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['games'][0]['id'], $game->id);

        $game = factory(Game::class)->create(['stage_id' => $stage->id, 'created_at' => 2]);

        $this->get('api/leagues/' . $game->stage->competition->organization->id . '/games?order_by=created_at&order_direction=desc&limit=1', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['games'][0]['id'], $game->id);

        $game = factory(Game::class)->create(['stage_id' => $stage->id, 'created_at' => 3]);

        $this->get('api/leagues/' . $game->stage->competition->organization->id . '/games?order_by=created_at&order_direction=desc&limit=1', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['games'][0]['id'], $game->id);

        $game = factory(Game::class)->create(['stage_id' => $stage->id, 'created_at' => 4]);

        $this->get('api/leagues/' . $game->stage->competition->organization->id . '/games?order_by=created_at&order_direction=desc&limit=1', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['games'][0]['id'], $game->id);

    }
}
