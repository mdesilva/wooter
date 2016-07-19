<?php

namespace Wooter\Providers;

use Illuminate\Support\ServiceProvider;
use Wooter\Wooter\Repositories\UserTokenRepository;

class UserTokenServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('user_token', function ($app) {
            $connection = $app['db']->connection();

            // The database token repository is an implementation of the token repository
            // interface, and is responsible for the actual storing of auth tokens and
            // their e-mail addresses. We will inject this table and hash key to it.
            $table = $app['config']['auth.verify_user.table'];

            $key = $app['config']['app.key'];

            $expire = $app['config']->get('auth.verify_user.expire', 60);

            return new UserTokenRepository($connection, $table, $key, $expire);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['user_token'];
    }
}
