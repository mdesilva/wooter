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


class FacebookIntegrationCommand extends Command implements SelfHandling
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
     * @var UserRepository
     */
    private $userRepository;

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
     * @throws Exception
     */
    public function handle(UserRepository $userRepository, FacebookService $fb, Socialite $socialite, FacebookFriendshipsRepository $facebookFriendshipsRepository)
    {
        if (Auth::check()) {
            $this->fb = $fb;
            $this->socialite = $socialite;
            $this->userRepository = $userRepository;

            $facebookUser = $this->socialite->driver('facebook')->user();

            $wooterUser = $userRepository->getFromFacebookId($facebookUser->id);

            if (! $wooterUser) {
                $wooterUser = $this->synchronizeWithFacebook($facebookUser);
            }

            $this->fetchAndStoreFacebookFriends($facebookUser, $wooterUser, $facebookFriendshipsRepository);

            return $wooterUser;
        }

        throw new Exception('User not logged in');

    }

    private function fetchAndStoreFacebookFriends($facebookUser, $wooterUser, FacebookFriendshipsRepository $facebookFriendshipsRepository)
    {
        $friends = $this->fb->getFriends($facebookUser);

        foreach ($friends as $friend) {
            $facebookFriendshipsRepository->createFriendship($wooterUser->id, $facebookUser->id, $friend['id']);
        }
    }

    private function synchronizeWithFacebook($facebookUser)
    {
        $user = Auth::user();

        $user->facebook_id = $facebookUser->id;
        $user->facebook_integrated = 1;

        return $this->userRepository->update($user);
    }
}
