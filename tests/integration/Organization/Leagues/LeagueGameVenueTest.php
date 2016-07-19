<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\City;
use Wooter\GameVenue;
use Wooter\LeagueOrganization;
use Wooter\LeagueGameVenue;

class LeagueGameVenueTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     */
    public function it_creates_a_league_game_venue()
    {
        $this->createALeagueAndAGameVenue();
    }

    private function createLeagueGameVenue(LeagueOrganization $league)
    {
        $city = factory(City::class)->create();
        $latitude = round($this->faker->latitude, 10);
        $longitude = round($this->faker->longitude, 11);
        $zip = $this->faker->postcode;
        $name = $this->faker->name;
        $street = $this->faker->streetName;
        $fullAddress = $this->faker->streetAddress;
        $flat = $this->faker->buildingNumber;
        $courtName = $this->faker->name;
        $numberOfCourts = $this->faker->numberBetween(1,10);

        $data = [
            'name' => $name,
            'full_address' => $fullAddress,
            'zip_code' => $zip,
            'country_id' => $city->country->id,
            'city_name' => $city->name,
            'state' => 'NY',
            'longitude' => $longitude,
            'latitude' => $latitude,
            'street' => $street,
            'flat' => $flat,
            'court_name' => $courtName,
            'number_of_courts' => $numberOfCourts,
        ];

        $this->post('api/leagues/' . $league->id . '/game-venues', $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertSame($result['data']['league_id'], $league->id);
        $this->assertSame($result['data']['game_venue']['location']['longitude'], $longitude);
        $this->assertSame($result['data']['game_venue']['location']['latitude'], $latitude);
        $this->assertSame($result['data']['game_venue']['location']['city'], $city->name);
        $this->assertSame($result['data']['game_venue']['location']['country'], $city->country->name);
        $this->assertSame($result['data']['game_venue']['location']['street'], $street);
        $this->assertSame($result['data']['game_venue']['location']['full_address'], $fullAddress);
        $this->assertSame($result['data']['game_venue']['location']['flat'], $flat);
        $this->assertSame($result['data']['game_venue']['number_of_courts'], $numberOfCourts);
        $this->assertSame($result['data']['game_venue']['court_name'], $courtName);

        $league = LeagueOrganization::whereId($league->id)->first();

        $gameVenue = $league->game_venues->first();
        $this->assertSame($gameVenue->location->name, $name);
        $this->assertSame(round($gameVenue->location->latitude, 10), $latitude);
        $this->assertSame(round($gameVenue->location->longitude, 11), $longitude);
        $this->assertSame($gameVenue->location->city->id, $city->id);
        $this->assertSame($gameVenue->location->city->name, $city->name);
        $this->assertSame($gameVenue->location->country->id, $city->country->id);
        $this->assertSame($gameVenue->location->country->name, $city->country->name);
        $this->assertSame($gameVenue->location->street, $street);
        $this->assertSame($gameVenue->location->flat, $flat);
        return $gameVenue->id;
    }

    private function createALeagueAndAGameVenue()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();
        $league = LeagueOrganization::first();
        $this->createLeagueGameVenue($league);
        return $league->id;
    }
    /**
     * @test
     */
    public function it_edits_a_league_game_venue()
    {
        $leagueId = $this->createALeagueAndAGameVenue();
        $league = LeagueOrganization::whereId($leagueId)->first();

        $city = factory(City::class)->create();
        $latitude = round($this->faker->latitude, 10);
        $longitude = round($this->faker->longitude, 11);
        $zip = $this->faker->postcode;
        $name = $this->faker->name;
        $street = $this->faker->streetName;
        $fullAddress = $this->faker->streetAddress;
        $flat = $this->faker->buildingNumber;
        $courtName = $this->faker->name;
        $numberOfCourts = $this->faker->numberBetween(1,10);

        $data = [
            'name' => $name,
            'full_address' => $fullAddress,
            'zip_code' => $zip,
            'country_id' => $city->country->id,
            'city_name' => $city->name,
            'state' => 'NY',
            'longitude' => $longitude,
            'latitude' => $latitude,
            'street' => $street,
            'flat' => $flat,
            'court_name' => $courtName,
            'number_of_courts' => $numberOfCourts,
        ];

        $gameVenue = $league->game_venues->first();

        $this->put('api/leagues/' . $league->id . '/game-venues/' . $gameVenue->id, $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertSame($result['data']['league_id'], $league->id);
        $this->assertSame($result['data']['game_venue']['location']['name'], $name);
        $this->assertSame($result['data']['game_venue']['location']['longitude'], $longitude);
        $this->assertSame($result['data']['game_venue']['location']['latitude'], $latitude);
        $this->assertSame($result['data']['game_venue']['location']['city'], $city->name);
        $this->assertSame($result['data']['game_venue']['location']['country'], $city->country->name);
        $this->assertSame($result['data']['game_venue']['location']['street'], $street);
        $this->assertSame($result['data']['game_venue']['location']['full_address'], $fullAddress);
        $this->assertSame($result['data']['game_venue']['location']['flat'], $flat);
        $this->assertSame($result['data']['game_venue']['number_of_courts'], $numberOfCourts);
        $this->assertSame($result['data']['game_venue']['court_name'], $courtName);

        $league = LeagueOrganization::whereId($league->id)->first();

        $gameVenue = $league->game_venues->first();
        $this->assertSame($gameVenue->location->name, $name);
        $this->assertSame(round($gameVenue->location->latitude, 10), $latitude);
        $this->assertSame(round($gameVenue->location->longitude, 11), $longitude);
        $this->assertSame($gameVenue->location->city->id, $city->id);
        $this->assertSame($gameVenue->location->city->name, $city->name);
        $this->assertSame($gameVenue->location->country->id, $city->country->id);
        $this->assertSame($gameVenue->location->country->name, $city->country->name);
        $this->assertSame($gameVenue->location->street, $street);
        $this->assertSame($gameVenue->location->flat, $flat);
    }
    /**
     * @test
     */
    public function it_deletes_a_league_game_venue()
    {
        $leagueId = $this->createALeagueAndAGameVenue();
        $league = LeagueOrganization::whereId($leagueId)->first();
        $gameVenue = $league->game_venues->first();

        $this->delete('api/leagues/' . $league->id . '/game-venues/' . $gameVenue->id, [], $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertEquals($result['data'], 'Success');
        $leagueGameVenue = GameVenue::whereId($gameVenue->id)->first();
        $this->assertNull($leagueGameVenue);
        $league = LeagueOrganization::whereId($league->id)->first();
        $this->assertEmpty($league->game_venues);
    }
    /**
     * @test
     */
    public function it_reads_a_league_game_venue()
    {
        $leagueId = $this->createALeagueAndAGameVenue();
        $league = LeagueOrganization::whereId($leagueId)->first();
        $gameVenue = $league->game_venues->first();

        $this->get('api/leagues/' . $league->id . '/game-venues/' . $gameVenue->id, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['league_id'], $league->id);
        $this->assertSame($result['data']['game_venue']['location']['name'], $league->fresh()->game_venues()->first()->location->name);
        $this->assertSame($result['data']['game_venue']['location']['longitude'], round($league->fresh()->game_venues()->first()->location->longitude, 11));
        $this->assertSame($result['data']['game_venue']['location']['latitude'], round($league->fresh()->game_venues()->first()->location->latitude, 10));
        $this->assertSame($result['data']['game_venue']['location']['city'], $league->fresh()->game_venues()->first()->location->city->name);
        $this->assertSame($result['data']['game_venue']['location']['country'], $league->fresh()->game_venues()->first()->location->city->country->name);
        $this->assertSame($result['data']['game_venue']['location']['street'], $league->fresh()->game_venues()->first()->location->street);
        $this->assertSame($result['data']['game_venue']['location']['full_address'], $league->fresh()->game_venues()->first()->location->full_address);
        $this->assertSame($result['data']['game_venue']['location']['flat'], $league->fresh()->game_venues()->first()->location->flat);
        $this->assertSame($result['data']['game_venue']['number_of_courts'], $league->fresh()->game_venues()->first()->number_of_courts);
        $this->assertSame($result['data']['game_venue']['court_name'], $league->fresh()->game_venues()->first()->court_name);
    }
    /**
     * @test
     */
    public function it_get_all_game_venues_for_a_league()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();
        $league = LeagueOrganization::first();
        $leagueGameVenues = factory(LeagueGameVenue::class, 3)->create(['league_id' => $league->id]);

        $this->get('api/leagues/' . $league->id . '/game-venues', $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertCount(3, $result['data']);
    }
}