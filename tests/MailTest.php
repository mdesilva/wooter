<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

trait MailTest {

    public function getAllEmails()
    {
        $client = new Client;

        $emails = $client->get($this->baseMailTestingUrl . '/messages');
        /**
         * @var Response $emails
         */

        if (empty($emails)){
            $this->fail('No messages returned');
        }

        return json_decode((string) $emails->getBody(), true);
    }

    public function deleteAllEmails()
    {
        $client = new Client;

        return $client->delete($this->baseMailTestingUrl . '/messages');
    }

    public function getLastEmail()
    {
        $client = new Client;

        $allEmails = $this->getAllEmails();

        $emailId = $allEmails[count($allEmails) - 1]['id'];

        $email =  $client->get($this->baseMailTestingUrl . '/messages/' . $emailId . '.json');

        return (string)$email->getBody();
    }

    public function getEmailById($emailId)
    {
        $client = new Client;

        $email =  $client->get($this->baseMailTestingUrl . '/messages/' . $emailId . '.json');

        return (string)$email->getBody();
    }

    public function assertEmailBodyContains($body, $email)
    {
        $this->assertContains($body, $email);
    }

    public function assertNotEmailBodyContains($body, $email)
    {
        $this->assertNotContains($body, $email);
    }

    public function assertEmailWasSentTo($recipient, $email)
    {
        $email = json_decode($email, true);

        $this->assertContains("<{$recipient}>", $email['recipients'][0]);
    }

}