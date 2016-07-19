<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Wooter\PlayerLeague;
use Wooter\LeagueOrganization;
use Wooter\Stat;
use Wooter\Role;
use Wooter\User;
use Wooter\UserRole;

class LeaguePlayerTest extends TestCase
{
    use DatabaseTransactions;
    protected $currentUserLogged;

    /**
     * @test
     */
    public function it_adds_a_player_to_a_league_and_updates()
    {
        $user = $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create(['user_id' => $user->id]);

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $phone = $this->faker->phoneNumber;
        $email = $this->faker->email;
        $jersey = $this->faker->numberBetween(1,999);

        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'email' => $email,
            'jersey' => $jersey,
        ];

        $this->post('api/leagues/' . $league->id . '/players', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['id'], User::get()->last()->id);
        $this->assertEquals($result['data']['first_name'], $firstName);
        $this->assertEquals($result['data']['last_name'], $lastName);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['email'], $email);
    }

}
