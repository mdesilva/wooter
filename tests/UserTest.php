<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\Mock;
use Wooter\Role;
use Wooter\User;
use Illuminate\Support\Facades\Session;
use Wooter\UserVerification;
use Laravel\Socialite\Two\User as FacebookUser;
use Carbon\Carbon;

class UserTest extends TestCase
{
    use DatabaseTransactions, MailTest;

    protected $socialite;
    protected $facebookProvider;
    protected $facebookUser;
    protected $facebookService;

    public function facebookTestSetup()
    {
        $this->socialite = $this->mock('Laravel\Socialite\Contracts\Factory');
        $this->facebookProvider = $this->mock('Laravel\Socialite\Two\FacebookProvider');
        $this->facebookService = $this->mock('Wooter\Wooter\Services\FacebookService');
    }

    /**
     * @test
     */
    public function it_registers_a_basic_player_user()
    {
        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $password = $this->faker->password;
        $phone = $this->faker->phoneNumber;
        $gender = 'female';

        $this->post('/register', [
            'preselected_role' => Role::ATHLETE,
            'email' => $email,
            'phone' => $phone,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'password' => $password,
        ], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['first_name'], $firstName);
        $this->assertEquals($result['data']['last_name'], $lastName);
        $this->assertEquals($result['data']['gender'], $gender);
        $this->assertEquals($result['message'], 'Success');

        return User::whereEmail($email)->first();
    }

    /**
     * Testing the registration as a user
     * @test
     * @return void
     */
    public function it_registers_a_user_via_email_and_verifies_it_and_receives_successful_verification_email()
    {
        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $password = $this->faker->password;
        $phone = $this->faker->phoneNumber;
        $gender = 'female';
        $day = $this->faker->numberBetween(1,31);
        $month = $this->faker->numberBetween(1,12);
        $year = $this->faker->numberBetween(1900,date('Y'));

        // Registration
        $this->post('/register', [
            'preselected_role' => Role::ATHLETE,
            'email' => $email,
            'phone' => $phone,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'password' => $password,
            'password_confirmation' => $password,
        ], $this->headers);

        $user = User::whereEmail($email)->first();
        // Assure user is not verified (because was registered via email)
        $this->assertSame('0', $user->verified);

        // Check registration email was received
        $latestEmailSent = $this->getLastEmail();

        $this->assertEmailBodyContains('Verify your account', $latestEmailSent);
        $this->assertEmailBodyContains("Hello {$firstName}", $latestEmailSent);
        $this->assertEmailWasSentTo($email, $latestEmailSent);

        // Click on the link (on the registration email) in order to verify the account
        $userToVerify = UserVerification::whereUserId($user->id)->first();
        $token = $userToVerify->token;
        $this->get('/verify-user/' . $token);

        // Check that the user was verified
        $user = User::whereEmail($email)->first();
        $this->assertSame('1', $user->verified);

        // Check that the user received the successful registration upon account verification
        $latestEmailSent = $this->getLastEmail();
        $this->assertEmailBodyContains('Success!!', $latestEmailSent);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Testing the registration as a user
     * @test
     * @return void
     */
    public function it_registers_a_user_via_facebook_and_receives_successful_registration_email()
    {
        $this->facebookTestSetup();

        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $day = $this->faker->dayOfMonth;
        $month = $this->faker->month;
        $year = $this->faker->year;
        $phone = $this->faker->phoneNumber;
        $facebookId = $this->faker->numberBetween(1, 10000000000);


        $facebookUser = new FacebookUser;

        $facebookUser->id = $facebookId;
        $facebookUser->email = $email;


        $facebookUser->user = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => 'male',
            'birthday' => "{$month}/{$day}/{$year}"
        ];

        $this->facebookService->shouldReceive('getFullUser')->andReturn($facebookUser);

        $this->facebookProvider->shouldReceive('user')->andReturn($facebookUser);

        $this->socialite->shouldReceive('driver')->andReturn($this->facebookProvider);

        $this->get('/auth/facebook/callback');

        // Check user has state verified (verified == "1")
        $user = User::whereEmail($email)->first();
        $this->assertSame('1', $user->verified);
        $this->assertSame($email, $user->email);
        $this->assertSame($firstName, $user->first_name);
        $this->assertSame($lastName, $user->last_name);
        $this->assertSame((new Carbon("{$month}/{$day}/{$year} 00:00:00"))->toDateTimeString(), $user->birthday);
        $this->assertSame('male', $user->gender);
        $this->assertSame('1', $user->facebook_integrated);
        $this->assertSame($facebookId, $user->facebook_id);


        // Check user received successful registration email (final one)

        $this->assertInstanceOf(User::class, $user);
    }
}
