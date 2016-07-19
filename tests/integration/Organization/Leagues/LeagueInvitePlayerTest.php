<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueGameVenue;
use Wooter\LeagueVideo;
use Wooter\Team;
use Wooter\User;
use Wooter\Video;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class LeagueInvitePlayer extends TestCase
{
    use MailTest, DatabaseTransactions;

    /**
     * @test
     */
    public function it_invites_a_player_to_a_league()
    {
        $user = $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create(['user_id' => $user->id]);

        $email = $this->faker->email;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        $data = [
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName
        ];

        $this->post('api/leagues/' . $league->id . '/players', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertContains($result['message'], 'Invitation Successfully Sent');

        // Check registration email was received
        $latestEmailSent = json_decode($this->getLastEmail(), true);
        $source = quoted_printable_decode($latestEmailSent['source']);
        preg_match('|<a class="invite-player-url" href=".*(/api/leagues.*?)"|', $source, $matches);

        $basicUser = $this->createAndLoginABasicUser();
        /* todo fix this to check emails are working on future
        $this->get($matches[1]);

        $this->assertRedirectedTo('/');
        $this->seeCookie('actionAlert');
        */

    }

}
