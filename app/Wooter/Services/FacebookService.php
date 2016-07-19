<?php

namespace Wooter\Wooter\Services;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Laravel\Socialite\Contracts\User as FacebookUser;

class FacebookService {

    protected $facebook;

    public function __construct()
    {
        $this->facebook = new Facebook([
            'app_id' => env('FACEBOOK_ID'),
            'app_secret' => env('FACEBOOK_SECRET'),
            'default_graph_version' => 'v2.2',
        ]);
    }

    public function getFriends(FacebookUser $facebookUser)
    {
        $result = [];
        try {
            $response = $this->facebook->get('/me/friends', $facebookUser->token);

            $data = $response->getDecodedBody();
            if (isset($data['data']) && count($data['data']) > 0) {
                $result = $data['data'];
            }
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $result;
    }

    public function getFullUser(FacebookUser $facebookUser)
    {
        try {
            $response = $this->facebook->get('/me?fields=name,birthday', $facebookUser->token);
            return $response->getDecodedBody();
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

}