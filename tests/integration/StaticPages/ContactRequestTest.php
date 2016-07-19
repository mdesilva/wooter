<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Wooter\LeagueOrganization;
use Illuminate\Support\Facades\Auth;
use Wooter\Wooter\Contracts\HTTPStatusCode;


class ContactRequestTest extends TestCase
{
    use DatabaseTransactions, MailTest;

    /**
     * A basic test example.
     * @test
     */
    public function it_requests_a_contact_request()
    {
        $email = $this->faker->email;
        $name = $this->faker->name;
        $phone = $this->faker->phoneNumber;
        $comments = 'Testing';
        

        $data = [
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'comments' => $comments,
        ];

        $this->post('/contact', $data);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['status'], 'success');
    }

    

}
