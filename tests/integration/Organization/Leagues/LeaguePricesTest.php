<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\LeagueOrganization;
use Wooter\LeaguePrice;

class LeaguePricesTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * @test
     */
    public function it_creates_a_league_price()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $price = $this->faker->numberBetween(10,100);
        $description = $this->faker->sentence;
        $url = $this->faker->url;
        $name = $this->faker->sentence();

        $data = [
            'price' => $price,
            'name' => $name,
            'description' => $description,
            'url' => $url,
        ];

        $this->post('api/leagues/' . $league->id . '/prices', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['price'], $price);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['description'], $description);
        $this->assertEquals($result['data']['url'], $url);
    }

    /**
     * @test
     */
    public function it_reads_a_league_price()
    {
        $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create();

        $leaguePrice = factory(LeaguePrice::class)->create(['league_id' => $league->id]);

        $this->get('api/leagues/' . $league->id . '/prices/' . $leaguePrice->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['price'], $leaguePrice->price);
        $this->assertEquals($result['data']['name'], $leaguePrice->name);
        $this->assertEquals($result['data']['description'], $leaguePrice->description);
        $this->assertEquals($result['data']['url'], $leaguePrice->url);
    }

    /**
     * @test
     */
    public function it_reads_the_league_prices()
    {
        $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create();

        $leaguePrices = factory(LeaguePrice::class,10)->create(['league_id' => $league->id]);

        $this->get('api/leagues/' . $league->id . '/prices', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $i = 0;
        foreach ($leaguePrices as $leaguePrice) {
            $this->assertEquals($result['data'][$i]['league_id'], $league->id);
            $this->assertEquals($result['data'][$i]['price'], $leaguePrice->price);
            $this->assertEquals($result['data'][$i]['name'], $leaguePrice->name);
            $this->assertEquals($result['data'][$i]['description'], $leaguePrice->description);
            $this->assertEquals($result['data'][$i]['url'], $leaguePrice->url);
            $i++;
        }
    }

    /**
     * @test
     */
    public function it_updates_a_league_price()
    {
        $user = $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create(['user_id' => $user->id]);

        $leaguePrice = factory(LeaguePrice::class)->create(['league_id' => $league->id]);

        $price = $this->faker->numberBetween(10,100);
        $description = $this->faker->sentence;
        $name = $this->faker->sentence;
        $url = $this->faker->url;

        $data = [
            'price' => $price,
            'description' => $description,
            'name' => $name,
            'url' => $url,
        ];

        $this->put('api/leagues/' . $league->id . '/prices/' . $leaguePrice->id, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['price'], $price);
        $this->assertEquals($result['data']['description'], $description);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['url'], $url);
    }

    /**
     * @test
     */
    public function it_deletes_a_league_price()
    {
        $user = $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create(['user_id' => $user->id]);

        $leaguePrice = factory(LeaguePrice::class)->create(['league_id' => $league->id]);

        $this->delete('api/leagues/' . $league->id . '/prices/' . $leaguePrice->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data'], 'Successfully Deleted');
        $this->assertNull($leaguePrice->fresh());
    }

}
