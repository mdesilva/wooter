<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Wooter\LeagueOrganization;
use Illuminate\Support\Facades\Auth;
use Wooter\LeagueBasics;
use Wooter\LeagueDetails;
use Wooter\LeagueLocation;
use Wooter\Location;
use Wooter\Organization;
use Wooter\Role;
use Wooter\ServiceRequest;
use Wooter\Sport;
use Wooter\User;
use Wooter\Wooter\Contracts\HTTPStatusCode;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\SlugExistsException;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;

class ServiceRequestTest extends TestCase
{
    use DatabaseTransactions, MailTest;

    /**
     * A basic test example.
     * @test
     */
    public function it_requests_a_video_demo()
    {
        $email = $this->faker->email;
        $name = $this->faker->name;
        $phone = $this->faker->phoneNumber;
        $type = ServiceRequest::TYPE_VIDEO;
        $sport = 'Basketball';
        $address_1 = $this->faker->address;
        $address_2 = $this->faker->address;
        $numberOfPlayers = $this->faker->numberBetween(2,15);
        $numberOfTeams = $this->faker->numberBetween(2,15);
        $numberOfGamesPerTeam = $this->faker->numberBetween(2,15);

        $data = [
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'type' => $type,
            'sport' => $sport,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'number_of_players' => $numberOfPlayers,
            'number_of_teams' => $numberOfTeams,
            'number_of_games_per_team' => $numberOfGamesPerTeam,
        ];

        $this->post('api/service-requests', $data);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['type'], $type);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['sport'], $sport);
        $this->assertEquals($result['data']['address_1'], $address_1);
        $this->assertEquals($result['data']['address_2'], $address_2);
        $this->assertEquals($result['data']['number_of_players'], $numberOfPlayers);
        $this->assertEquals($result['data']['number_of_teams'], $numberOfTeams);
        $this->assertEquals($result['data']['number_of_games_per_team'], $numberOfGamesPerTeam);
    }

    /**
     * A basic test example.
     * @test
     */
    public function it_requests_a_referee_demo()
    {
        $email = $this->faker->email;
        $name = $this->faker->name;
        $phone = $this->faker->phoneNumber;
        $type = ServiceRequest::TYPE_REFEREE;
        $sport = 'Basketball';
        $address_1 = $this->faker->address;
        $address_2 = $this->faker->address;
        $numberOfPlayers = $this->faker->numberBetween(2,15);
        $numberOfTeams = $this->faker->numberBetween(2,15);
        $numberOfGamesPerTeam = $this->faker->numberBetween(2,15);

        $data = [
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'type' => $type,
            'sport' => $sport,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'number_of_players' => $numberOfPlayers,
            'number_of_teams' => $numberOfTeams,
            'number_of_games_per_team' => $numberOfGamesPerTeam,
        ];

        $this->post('api/service-requests', $data);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['type'], $type);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['sport'], $sport);
        $this->assertEquals($result['data']['address_1'], $address_1);
        $this->assertEquals($result['data']['address_2'], $address_2);
        $this->assertEquals($result['data']['number_of_players'], $numberOfPlayers);
        $this->assertEquals($result['data']['number_of_teams'], $numberOfTeams);
        $this->assertEquals($result['data']['number_of_games_per_team'], $numberOfGamesPerTeam);
    }

    /**
     * A basic test example.
     * @test
     */
    public function it_requests_a_video_demo_and_admin_reads_it()
    {
        $admin = $this->createAndLoginAnAdmin();

        $serviceRequest = factory(ServiceRequest::class)->create();

        $this->get('api/service-requests/' . $serviceRequest->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['email'], $serviceRequest->email);
        $this->assertEquals($result['data']['name'], $serviceRequest->name);
        $this->assertEquals($result['data']['type'], $serviceRequest->type);
        $this->assertEquals($result['data']['phone'], $serviceRequest->phone);
        $this->assertEquals($result['data']['sport'], $serviceRequest->sport);
        $this->assertEquals($result['data']['address_1'], $serviceRequest->address_1);
        $this->assertEquals($result['data']['address_2'], $serviceRequest->address_2);
        $this->assertEquals($result['data']['number_of_players'], $serviceRequest->number_of_players);
        $this->assertEquals($result['data']['number_of_teams'], $serviceRequest->number_of_teams);
        $this->assertEquals($result['data']['number_of_games_per_team'], $serviceRequest->number_of_games_per_team);
    }

    /**
     * A basic test example.
     * @test
     */
    public function it_requests_a_video_demo_and_admin_deletes_it()
    {
        $admin = $this->createAndLoginAnAdmin();

        $serviceRequest = factory(ServiceRequest::class)->create();

        $this->delete('api/service-requests/' . $serviceRequest->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data'], 'Deleted successfully');

        $this->assertNull($serviceRequest->fresh());
    }

    /**
     * A basic test example.
     * @test
     */
    public function admin_reads_all_services_requests()
    {
        $admin = $this->createAndLoginAnAdmin();

        $serviceRequestCollection = factory(ServiceRequest::class, 5)->create();
        /**
         * @var $serviceRequestCollection Collection
         */

        $this->get('api/service-requests/', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $results = json_decode($this->response->content(),true);

        foreach ($results['data'] as $result) {
            $serviceRequest = $serviceRequestCollection->shift();
            $this->assertEquals($result['email'], $serviceRequest->email);
            $this->assertEquals($result['name'], $serviceRequest->name);
            $this->assertEquals($result['type'], $serviceRequest->type);
            $this->assertEquals($result['phone'], $serviceRequest->phone);
            $this->assertEquals($result['sport'], $serviceRequest->sport);
            $this->assertEquals($result['address_1'], $serviceRequest->address_1);
            $this->assertEquals($result['address_2'], $serviceRequest->address_2);
            $this->assertEquals($result['number_of_players'], $serviceRequest->number_of_players);
            $this->assertEquals($result['number_of_teams'], $serviceRequest->number_of_teams);
            $this->assertEquals($result['number_of_games_per_team'], $serviceRequest->number_of_games_per_team);
        }
    }

    /**
     * A basic test example.
     * @test
     */
    public function normal_reads_all_services_requests_and_gets_forbidden()
    {

    }

    /**
     * A basic test example.
     * @test
     */
    public function normal_reads_a_service_request_and_gets_forbidden()
    {

    }

}
