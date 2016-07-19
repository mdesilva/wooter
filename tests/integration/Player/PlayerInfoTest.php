<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Wooter\LeagueOrganization;
use Wooter\Team;
use Wooter\User;

class PlayerInfoTest extends TestCase
{
    use DatabaseTransactions, MailTest;

    /**
     * @test
     */
    public function it_updates_the_player_info()
    {
        $player = $this->createAndLoginABasicUser();

        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $day = $this->faker->dayOfMonth;
        $month = $this->faker->month;
        $year = $this->faker->year;
        $phone = $this->faker->phoneNumber;
        $gender = 'female';
        $birthday = $year . '-' . $month . '-' . $day;
        $school = $this->faker->name;
        $position = $this->faker->name;
        $city = $this->faker->city;
        $state = $this->faker->countryCode;

        $data = [
            'email' => $email,
            'phone' => $phone,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'birthday' => $birthday,
            'school' => $school,
            'position' => $position,
            'city' => $city,
            'state' => $state,
        ];

        $this->put('/api/player/info', $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['first_name'], $firstName);
        $this->assertEquals($result['data']['last_name'], $lastName);
        $this->assertEquals($result['data']['state'], $state);
        $this->assertEquals($result['data']['city'], $city);
        $this->assertEquals($result['data']['school'], $school);
        $this->assertEquals($result['data']['gender'], $gender);
        $this->assertEquals($result['data']['birthday'], $birthday);
    }

    /**
     * @test
     */
    public function it_changes_the_password_of_a_player_in_settings()
    {
        $password = $this->faker->password;
        $newPassword = $this->faker->password;
        $passwordEncrypted = bcrypt($password);

        $player = $this->verifyUser($this->registerUser(['password' => $passwordEncrypted]));

        $this->assertFalse($player->isAdmin());
        $this->assertFalse($player->isOrganization());

        $this->loginAUserByCredentials($player->email, $password);

        $data = [
            'old_password' => $password,
            'new_password' => $newPassword,
            'confirm_password' => $newPassword,
        ];
        $this->put('/api/player/change-password', $data, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertTrue(Hash::check($newPassword, $player->fresh()->password));
        $this->assertEquals($result['data'], 'Password changed successfully');
    }
}
