<?php

namespace spec\Wooter\Http\Controllers\Auth;

use Laravel\Socialite\Two\FacebookProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Laravel\Socialite\Contracts\Factory as Socialite;

class FacebookControllerSpec extends ObjectBehavior
{
    function let(Socialite $socialite)
    {
        $this->beConstructedWith($socialite);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Wooter\Http\Controllers\Auth\FacebookController');
    }

    function it_redirects_to_provider(FacebookProvider $facebookProvider, Socialite $socialite)
    {
        $facebookProvider->scopes(["user_friends", "user_birthday"])->willReturn($facebookProvider);
        $facebookProvider->redirect()->shouldBeCalled();

        $socialite->driver('facebook')->willReturn($facebookProvider);

        $this->redirectToProvider();
    }
}
