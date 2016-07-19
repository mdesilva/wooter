<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\FollowLeague;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;

class FollowLeagueTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_follows_a_league()
    {
        $user = $this->createAndLoginABasicUser();

        $league = factory(LeagueOrganization::class)->create();

        $data = [
            'league_id' => $league->id
        ];

        $this->post('api/follow-league', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['message'], 'Success');
        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['name'], $league->name);
        $this->assertEquals($result['data']['status'], FollowLeague::FOLLOWING);
        $this->assertEquals($result['data']['user_id'], $user->id);

        $this->get('api/follow-league/' . $league->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['message'], 'Success');
        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['name'], $league->name);
        $this->assertEquals($result['data']['status'], FollowLeague::FOLLOWING);
        $this->assertEquals($result['data']['user_id'], $user->id);

        $this->post('api/follow-league', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['message'], 'Success');
        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['name'], $league->name);
        $this->assertEquals($result['data']['status'], FollowLeague::UNFOLLOWING);
        $this->assertEquals($result['data']['user_id'], $user->id);


    }

    /**
     * @test
     */
    public function it_retrieves_all_leagues_being_followed()
    {
        $user = $this->createAndLoginABasicUser();

        $followLeagues = factory(FollowLeague::class)->times(5)->create(['user_id' => $user->id]);
        factory(FollowLeague::class)->times(5)->create(['user_id' => $user->id, 'status' => FollowLeague::UNFOLLOWING]);

        $this->get('api/follow-league', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $currentFollowLeague = 0;
        foreach ($followLeagues as $followLeague) {

            $this->assertEquals($result['data'][$currentFollowLeague]['league_id'], $followLeague->league_id);
            $this->assertEquals($result['data'][$currentFollowLeague]['status'], FollowLeague::FOLLOWING);
            $this->assertEquals($result['data'][$currentFollowLeague]['user_id'], $followLeague->user_id);

            $currentFollowLeague++;

        }
    }

}
