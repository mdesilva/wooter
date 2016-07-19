<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Wooter\LeagueOrganization;
use Wooter\Team;
use Wooter\User;

class PlayerTest extends TestCase
{
    use DatabaseTransactions, MailTest;

    public function setUp()
    {
        parent::setUp();

        $this->deleteAllEmails();
    }

    /**
     * @test
     */
    public function it_creates_a_player_as_admin_and_user_receives_notifications()
    {
        $this->markTestIncomplete();
        $admin = $this->createAndLoginAnOrganization();

        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $day = $this->faker->dayOfMonth;
        $month = $this->faker->month;
        $year = $this->faker->year;
        $phone = $this->faker->phoneNumber;
        $gender = 'female';
        $birthday = $year . '-' . $month . '-' . $day;

        $this->post('/api/players', [
            'email' => $email,
            'phone' => $phone,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'birthday' => $birthday,
        ], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['first_name'], $firstName);
        $this->assertEquals($result['data']['last_name'], $lastName);
        $this->assertEquals($result['data']['gender'], $gender);
        $this->assertEquals($birthday, $result['data']['birthday']);
        $latestEmailSent = $this->getLastEmail();

        $this->assertEmailBodyContains('You have been added to Wooter!', $latestEmailSent);
        $this->assertEmailBodyContains("Hello {$firstName}", $latestEmailSent);
        $this->assertEmailWasSentTo($email, $latestEmailSent);
    }

    /**
     * @test
     */
    public function it_creates_a_player_as_league_owner_and_user_receives_notifications()
    {
        $this->markTestIncomplete();
        $user = $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create(['user_id' => $user->id]);

        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $day = $this->faker->dayOfMonth;
        $month = $this->faker->month;
        $year = $this->faker->year;
        $phone = $this->faker->phoneNumber;
        $gender = 'female';
        $birthday = $year . '-' . $month . '-' . $day;

        $this->post('/api/players', [
            'email' => $email,
            'phone' => $phone,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'birthday' => $birthday,
            'league_id' => $league->id
        ], $this->getHeaders());

        $allSentEmails = $this->getAllEmails();


        $this->assertCount(1, $allSentEmails);

        $emailAddedToWooter = $allSentEmails[0];
        $emailAddedToWooterContent = $this->getEmailById($allSentEmails[0]['id']);

        $this->assertEmailBodyContains('You have been added to Wooter', $emailAddedToWooter['subject']);
        $this->assertEquals("<{$email}>", $emailAddedToWooter['recipients'][0]);
        $this->assertEmailBodyContains("Hello {$firstName}", $emailAddedToWooterContent);


        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['first_name'], $firstName);
        $this->assertEquals($result['data']['last_name'], $lastName);
        $this->assertEquals($result['data']['gender'], $gender);
        $this->assertEquals($birthday, $result['data']['birthday']);
    }

    /**
     * @test
     */
    public function it_creates_a_player_as_team_owner_and_user_receives_notifications()
    {
        $this->markTestIncomplete();
        $this->createAndLoginAnOrganization();

        $team = factory(Team::class)->create();

        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $day = $this->faker->dayOfMonth;
        $month = $this->faker->month;
        $year = $this->faker->year;
        $phone = $this->faker->phoneNumber;
        $gender = 'female';
        $birthday = $year . '-' . $month . '-' . $day;

        $this->post('/api/players', [
            'email' => $email,
            'phone' => $phone,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'birthday' => $birthday,
            'team_id' => $team->id
        ], $this->getHeaders());

        $allSentEmails = $this->getAllEmails();

        $this->assertCount(1, $allSentEmails);

        $emailAddedToWooter = $allSentEmails[0];
        $emailAddedToWooterContent = $this->getEmailById($allSentEmails[0]['id']);

        $this->assertEmailBodyContains('You have been added to Wooter', $emailAddedToWooter['subject']);
        $this->assertEquals("<{$email}>", $emailAddedToWooter['recipients'][0]);
        $this->assertEmailBodyContains("Hello {$firstName}", $emailAddedToWooterContent);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['first_name'], $firstName);
        $this->assertEquals($result['data']['last_name'], $lastName);
        $this->assertEquals($result['data']['gender'], $gender);
        $this->assertEquals($birthday, $result['data']['birthday']);
    }

    /**
     * @test
     */
    public function it_creates_a_player_as_league_owner_with_already_registered_playeremail_and_player_receives_notification_for_league()
    {
        $this->markTestIncomplete();
        $userWithOrganization = $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create(['organization_id' => $userWithOrganization->organization->id]);
        $player = factory(User::class)->create();

        $this->post('/api/players', [
            'email' => $player->email,
            'phone' => $player->phone,
            'first_name' => $player->first_name,
            'last_name' => $player->last_name,
            'gender' => $player->gender,
            'birthday' => $player->birthday,
            'league_id' => $league->id
        ], $this->getHeaders());

        $allSentEmails = $this->getAllEmails();

        $this->assertCount(1, $allSentEmails);

        $emailAddedToLeague = $allSentEmails[0];
        $emailAddedToLeagueContent = $this->getEmailById($allSentEmails[0]['id']);

        $this->assertEmailBodyContains('You have been added to league in Wooter', $emailAddedToLeague['subject']);
        $this->assertEquals("<{$player->email}>", $emailAddedToLeague['recipients'][0]);
        $this->assertEmailBodyContains("the league {$league->name} at Wooter.", $emailAddedToLeagueContent);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $player->email);
        $this->assertEquals($result['data']['phone'], $player->phone);
        $this->assertEquals($result['data']['first_name'], $player->first_name);
        $this->assertEquals($result['data']['last_name'], $player->last_name);
        $this->assertEquals($result['data']['gender'], $player->gender);
        $this->assertEquals($player->birthday . ' 00:00:00', $result['data']['birthday']);
    }

    /**
     * @test
     */
    public function it_creates_a_player_as_team_owner_with_already_registered_playeremail_and_player_receives_notification_for_league()
    {
        $this->markTestIncomplete();
        $this->createAndLoginABasicUser();

        $team = factory(Team::class)->create();
        $player = factory(User::class)->create();

        $this->post('/api/players', [
            'email' => $player->email,
            'phone' => $player->phone,
            'first_name' => $player->first_name,
            'last_name' => $player->last_name,
            'gender' => $player->gender,
            'birthday' => $player->birthday,
            'team_id' => $team->id
        ], $this->getHeaders());

        $allSentEmails = $this->getAllEmails();

        $this->assertCount(1, $allSentEmails);

        $emailAddedToTeam = $allSentEmails[0];
        $emailAddedToTeamContent = $this->getEmailById($allSentEmails[0]['id']);

        $this->assertEmailBodyContains("You have been added to the team: {$team->name}, at Wooter.", $emailAddedToTeam['subject']);
        $this->assertEquals("<{$player->email}>", $emailAddedToTeam['recipients'][0]);
        $this->assertEmailBodyContains("the team {$team->name} at Wooter.", $emailAddedToTeamContent);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $player->email);
        $this->assertEquals($result['data']['phone'], $player->phone);
        $this->assertEquals($result['data']['first_name'], $player->first_name);
        $this->assertEquals($result['data']['last_name'], $player->last_name);
        $this->assertEquals($result['data']['gender'], $player->gender);
        $this->assertEquals($player->birthday . ' 00:00:00', $result['data']['birthday']);
    }

    /**
     * @test
     */
    public function it_creates_a_player_as_league_owner_with_already_registered_playerphone_and_player_receives_notification_for_league()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function it_creates_a_player_as_admin_with_already_registered_playeremail_and_player_not_receives_notification_for_league()
    {
        $this->markTestIncomplete();
        $admin = $this->createAndLoginAnAdmin();

        $player = factory(User::class)->create();

        $this->post('/api/players', [
            'email' => $player->email,
            'phone' => $player->phone,
            'first_name' => $player->first_name,
            'last_name' => $player->last_name,
            'gender' => $player->gender,
            'birthday' => $player->birthday,
        ], $this->headers);

        $allSentEmails = $this->getAllEmails();

        $this->assertCount(0, $allSentEmails);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $player->email);
        $this->assertEquals($result['data']['phone'], $player->phone);
        $this->assertEquals($result['data']['first_name'], $player->first_name);
        $this->assertEquals($result['data']['last_name'], $player->last_name);
        $this->assertEquals($result['data']['gender'], $player->gender);
        $this->assertEquals($player->birthday . ' 00:00:00', $result['data']['birthday']);
    }

    /**
     * @test
     */
    public function it_creates_a_player_as_admin_with_already_registered_playerphone_and_player_receives_notification_for_league()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function it_checks_a_player_can_edit_himself()
    {
        $this->markTestIncomplete();
        $player = factory(User::class)->create();

        Session::start();
        Auth::login($player);

        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $day = $this->faker->dayOfMonth;
        $month = $this->faker->month;
        $year = $this->faker->year;
        $password = $this->faker->password();
        $phone = $this->faker->phoneNumber;
        $gender = 'female';
        $birthday = $year . '-' . $month . '-' . $day;

        $this->put('/api/players/' . $player->id, [
            'email' => $email,
            'phone' => $phone,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'birthday' => $birthday,
            'password' => $password,
            'password_confirmation' => $password,
        ], $this->headers);

        $allSentEmails = $this->getAllEmails();

        $this->assertCount(0, $allSentEmails);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['first_name'], $firstName);
        $this->assertEquals($result['data']['last_name'], $lastName);
        $this->assertEquals($result['data']['gender'], $gender);
        $this->assertEquals($birthday, $result['data']['birthday']);
    }

    /**
     * @test
     */
    public function it_checks_an_admin_can_delete_a_player()
    {
        $this->markTestIncomplete();
        $admin = $this->createAndLoginAnAdmin();

        $player = factory(User::class)->create();

        $this->delete('/api/players/' . $player->id, ['_token' => csrf_token()]);

        $allSentEmails = $this->getAllEmails();

        $this->assertCount(0, $allSentEmails);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data'], 'Deleted successfully');
        $player = User::whereId($player->id)->first();
        $this->assertNull($player);
    }

    /**
     * @test
     */
    public function it_reads_a_player_information()
    {
        $this->markTestIncomplete();
        $admin = $this->createAndLoginAnAdmin();

        $player = factory(User::class)->create();

        $this->get('/api/players/' . $player->id, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['email'], $player->email);
        $this->assertEquals($result['data']['phone'], $player->phone);
        $this->assertEquals($result['data']['first_name'], $player->first_name);
        $this->assertEquals($result['data']['last_name'], $player->last_name);
        $this->assertEquals($result['data']['gender'], $player->gender);
        $this->assertEquals($player->birthday . ' 00:00:00', $result['data']['birthday']);
    }
}
