<?php

use Illuminate\Support\Facades\Session;
use Wooter\LeagueOrganization;
use Wooter\Organization;
use Wooter\Role;
use Wooter\Sport;
use Wooter\User;
use Mockery\Mock;
use Illuminate\Support\Facades\Auth;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://woozard.dev';

    /**
     * Basic headers to Mock an AJAX Request
     *
     * @var array
     */
    protected $headers = [
        'HTTP_X-Requested-With' => 'XMLHttpRequest',
    ];

    protected $testPhotoPath = 'public/img/logo.png';

    /**
     * @var Faker\Generator $faker
     */
    protected $faker;

    protected $baseMailTestingUrl;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $this->faker = Faker\Factory::create();

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $this->baseMailTestingUrl = env('MAIL_BASE_TESTING_URL', 'http://192.168.10.10:1080/');

        return $app;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $header
     *
     * @internal param array $headers
     */
    public function addHeader(array $header)
    {
        $this->headers = array_merge($this->headers, $header);
    }

    /**
     * @param array $optionalData
     *
     * @return mixed
     */
    protected function registerUser($optionalData = []) {
        return factory(User::class)->create($optionalData);
    }

    /**
     * @param User $user
     *
     * @return User
     */
    protected function verifyUser(User $user)
    {
        return $user->verify();
    }

    protected function createLeague()
    {
        $data = [
            'name' => 'Liga de Fútbol Profesional Española',
            'sport_id' => Sport::BASKETBALL
        ];

        $this->post('api/leagues', $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['sport']['id'], Sport::BASKETBALL);

        return $result['data']['id'];
    }

    public function createLeagueAndSeason()
    {
        $leagueId = $this->createLeague();

        $name = $this->faker->name;
        $startsAt = $this->faker->date();
        $endAt = $this->faker->date();
        $opensAt = $this->faker->date();
        $closesAt = $this->faker->date();
        $maxTeams = $this->faker->numberBetween(5, 100);
        $maxFreeAgents = $this->faker->numberBetween(5, 100);
        $minTeams = $this->faker->numberBetween(2, 5);
        $minFreeAgents = $this->faker->numberBetween(2, 5);

        $data = [
            'name' => $name,
            'starts_at' => $startsAt,
            'ends_at' => $endAt,
            'registration_opens_at' => $opensAt,
            'registration_closes_at' => $closesAt,
            'max_teams' => $maxTeams,
            'max_free_agents' => $maxFreeAgents,
            'min_teams' => $minTeams,
            'min_free_agents' => $minFreeAgents,
        ];

        $this->post('api/leagues/'.$leagueId.'/seasons', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['starts_at'], $startsAt);
        $this->assertEquals($result['data']['ends_at'], $endAt);
        $this->assertEquals($result['data']['registration_opens_at'], $opensAt);
        $this->assertEquals($result['data']['registration_closes_at'], $closesAt);
        $this->assertEquals($result['data']['max_teams'], $maxTeams);
        $this->assertEquals($result['data']['max_free_agents'], $maxFreeAgents);
        $this->assertEquals($result['data']['min_teams'], $minTeams);
        $this->assertEquals($result['data']['min_free_agents'], $minFreeAgents);

        return $leagueId;
    }

    /**
     * Create a user as an admin
     */
    protected function createAndLoginABasicUser()
    {
        $password = $this->faker->password;
        $passwordEncrypted = bcrypt($password);
        
        $user = $this->verifyUser($this->registerUser(['password' => $passwordEncrypted]));

        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isOrganization());

        $this->loginAUserByCredentials($user->email, $password);

        return $user;
    }

    /**
     * Create a user as an admin
     */
    protected function createAndLoginAnAdmin()
    {
        $password = $this->faker->password;
        $passwordEncrypted = bcrypt($password);

        $user = $this->verifyUser($this->registerUser(['password' => $passwordEncrypted]));

        $user->makeAdmin();

        $admin = User::whereId($user->id)->first();

        $this->assertTrue($admin->isAdmin());

        $this->loginAUserByCredentials($admin->email, $password);

        return $user;
    }

    protected function loginAUserByCredentials($email, $password)
    {
        $data = [
            'email' => $email,
            'password' => $password,
        ];

        $this->post('api/authenticate', $data);

        $result = json_decode($this->response->content(), true);

        $this->addHeader([
            'Authorization' => 'Bearer '. $result['token']
        ]);
    }

    /**
     * Create a user as an organization
     */
    protected function createAndLoginAnOrganization()
    {
        $password = $this->faker->password;
        $passwordEncrypted = bcrypt($password);

        $user = $this->verifyUser($this->registerUser(['password' => $passwordEncrypted]));

        $user->makeOrganization();

        $this->assertTrue($user->isOrganization());

        $this->loginAUserByCredentials($user->email, $password);

        return $user;
    }

    /**
     * @param $class
     * @return Mock
     */
    protected function mock($class)
    {
        /**
         * @var $mock Mock
         */
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    protected function registerAndCreateLeague()
    {
        $this->registerAndLogin();
        $this->createLeague();

        $league = LeagueOrganization::first();

        return $league->id;
    }
}
