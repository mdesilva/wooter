<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\City;
use Wooter\GameStructure;
use Wooter\GameVenue;
use Wooter\LeagueOrganization;
use Wooter\LeagueGameVenue;

class GameStructuresTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     */
    public function it_gets_all_game_structures()
    {
        $user = $this->createAndLoginABasicUser();

        $gameStructures = GameStructure::all();

        $this->get('api/game-structures', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $i = 0;
        foreach ($gameStructures as $gameStructure) {
            $this->assertSame($result['data'][0]['id'], $gameStructure->id);
            $this->assertSame($result['data'][0]['name'], $gameStructure->name);
            $this->assertSame($result['data'][0]['name_localized'], $gameStructure->name_localized);
            $i++;
        }

    }
}