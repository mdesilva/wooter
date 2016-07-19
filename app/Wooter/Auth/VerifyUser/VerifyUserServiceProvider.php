<?php

namespace Wooter\Wooter\Auth\VerifyUser;

use Illuminate\Support\ServiceProvider;
use Wooter\Wooter\Auth\VerifyUser\DatabaseTokenRepository as DbRepository;

class VerifyUserServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerVerifyUserBroker();
    }

    /**
     * Register the verify user broker instance.
     *
     * @return void
     */
    protected function registerVerifyUserBroker()
    {
        $this->app->singleton('auth.verify_user', function ($app) {
            // The verify user token repository is responsible for storing the email addresses
            // and verify user tokens. It will be used to verify the tokens are valid
            // for the given e-mail addresses. We will resolve an implementation here.
            $tokens = $app['user_token'];

            $users = $app['auth']->driver()->getProvider();

            $view = $app['config']['auth.verify_user.email'];

            // The verify user broker uses a token repository to validate tokens and verify users.
            return new VerifyUserBroker(
                $tokens, $users, $app['mailer'], $view
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth.verify_user'];
    }
}
