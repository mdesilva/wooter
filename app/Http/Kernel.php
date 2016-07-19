<?php

namespace Wooter\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Wooter\Http\Middleware\LocalizationServices::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Wooter\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'ajax' => \Wooter\Http\Middleware\Ajax::class,
        'formly' => \Wooter\Http\Middleware\Formly::class,
        'media.check' => \Wooter\Http\Middleware\MediaCheck::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'user.is_guest' => \Wooter\Http\Middleware\User\RedirectIfAuthenticated::class,
        'user.has_organization' => \Wooter\Http\Middleware\User\UserHasOrganization::class,
        'user.is_player' => \Wooter\Http\Middleware\User\UserIsPlayer::class,
        'user.is_team_captain' => \Wooter\Http\Middleware\User\UserIsTeamCaptain::class,
        'user.is_organization' => \Wooter\Http\Middleware\User\UserIsOrganization::class,
        'user.is_organization_staff' => \Wooter\Http\Middleware\User\UserIsOrganizationStaff::class,
        'user.is_admin' => \Wooter\Http\Middleware\User\UserIsAdmin::class,
        'user.is_developer' => \Wooter\Http\Middleware\User\UserIsDeveloper::class,
        'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class
    ];
}
