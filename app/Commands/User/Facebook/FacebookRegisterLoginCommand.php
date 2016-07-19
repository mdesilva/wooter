<?php

namespace Wooter\Commands\User\Facebook;

use Auth;
use Carbon\Carbon;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Wooter\Inbox;
use Wooter\UserRole;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Role;
use Wooter\User;
use Wooter\Wooter\Repositories\Facebook\FacebookFriendshipsRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Exception;
use DB;
use Wooter\Wooter\Services\FacebookService;
use Laravel\Socialite\Contracts\User as FacebookUser;


class FacebookRegisterLoginCommand extends Command implements SelfHandling
{
    /**
     * @var FacebookService
     */
    private $fb;
    /**
     * @var Socialite
     */
    private $socialite;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     * @param FacebookService $fb
     * @param Socialite $socialite
     * @param FacebookFriendshipsRepository $facebookFriendshipsRepository
     * @return string
     */
    public function handle(UserRepository $userRepository, FacebookService $fb, Socialite $socialite, FacebookFriendshipsRepository $facebookFriendshipsRepository)
    {
        $this->fb = $fb;
        $this->socialite = $socialite;

        $facebookProvider = $this->socialite->driver('facebook');

        $facebookUser = $facebookProvider->user();

        $wooterUser = $this->createUserIfNotExists($facebookUser, $userRepository);

        $this->fetchAndStoreFacebookFriends($facebookUser, $wooterUser, $facebookFriendshipsRepository);

        return $wooterUser;
    }

    private function fetchAndStoreFacebookFriends(FacebookUser $facebookUser, $wooterUser, FacebookFriendshipsRepository $facebookFriendshipsRepository)
    {
        $friends = $this->fb->getFriends($facebookUser);

        foreach ($friends as $friend) {
            $facebookFriendshipsRepository->createFriendship($wooterUser->id, $facebookUser->id, $friend['id']);
        }
    }

    private function createUserIfNotExists(FacebookUser $facebookUser, UserRepository $userRepository)
    {
        $user = $userRepository->getFromFacebookId($facebookUser->id);

        if ($user) {
            return $user;
        }

        $facebookFullUser = $this->fb->getFullUser($facebookUser);

        if (isset($facebookFullUser['birthday'])) {
            $birthday = new Carbon($facebookFullUser['birthday']);
        } else {
            $birthday = false;
        }

        $user = new User;

        $facebUserObject = $facebookUser->user;

        if (isset($facebUserObject['first_name'])) {
            $user->first_name = $facebUserObject['first_name'];
        } elseif (isset($facebUserObject['name'])) {
            $user->first_name = $facebUserObject['name'];
        }

        if (isset($facebUserObject['last_name'])) {
            $user->last_name = $facebUserObject['last_name'];
        }

        $user->email = $facebookUser->email;
        $user->gender = $facebUserObject['gender'];
        $user->birthday = $birthday;
        $user->facebook_id = $facebookUser->id;
        $user->facebook_integrated = 1;
        $user->verified = 1;
        $userRepository->create($user);

        return $user;
    }

}
