<?php

namespace Wooter\Wooter\Auth\VerifyUser;

use Closure;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Mockery\CountValidator\Exception;
use UnexpectedValueException;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Wooter\Wooter\Contracts\Auth\CanVerifyUser as CanVerifyUserContract;
use Wooter\Wooter\Contracts\Auth\VerifyUserBroker as VerifyUserBrokerContract;
use Wooter\UserVerification;
use Wooter\Wooter\Contracts\Auth\TokenRepositoryContract;

class VerifyUserBroker implements VerifyUserBrokerContract
{
    /**
     * The verify user token repository.
     *
     * @var TokenRepositoryInterface
     */
    protected $tokens;

    /**
     * The user provider implementation.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    protected $users;

    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * The view of the verify user link e-mail.
     *
     * @var string
     */
    protected $emailView;

    /**
     * Create a new verify user broker instance.
     *
     * @param TokenRepositoryContract $tokens
     * @param  \Illuminate\Contracts\Auth\UserProvider $users
     * @param  \Illuminate\Contracts\Mail\Mailer $mailer
     *
     * @param  string $emailView
     */
    public function __construct(TokenRepositoryContract $tokens,
                                UserProvider $users,
                                MailerContract $mailer,
                                $emailView)
    {
        $this->users = $users;
        $this->mailer = $mailer;
        $this->tokens = $tokens;
        $this->emailView = $emailView;
    }

    /**
     * Send a verify user link to a user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    public function sendVerifyUserLink(array $credentials, Closure $callback = null)
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            throw new Exception('Invalid user');
        }

        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to verify their accounts. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.
        $token = $this->tokens->create($user);

        $this->emailVerifyLink($user, $token, $callback);

        return VerifyUserBrokerContract::VERIFY_USER_LINK_SENT;
    }

    /**
     * Send the verify user link via e-mail.
     *
     * @param  CanVerifyUserContract $user
     * @param  string  $token
     * @param  \Closure|null  $callback
     * @return int
     */
    public function emailVerifyLink(CanVerifyUserContract $user, $token, Closure $callback = null)
    {
        // We will use the reminder view that was given to the broker to display the
        // verify user e-mail. We'll pass a "token" variable into the views
        // so that it may be displayed for an user to click for verify the account.
        $view = $this->emailView;

        $mailingStrategy = env('MAILING_STRATEGY', 'send');

        $this->mailer->$mailingStrategy($view, compact('token', 'user'), function ($m) use ($user, $token, $callback) {
            $m->to($user->getEmailForVerifyUser());

            if (! is_null($callback)) {
                call_user_func($callback, $m, $user, $token);
            }
        });
    }

    /**
     * Verify the user for the given token.
     *
     * @param $token
     * @param callable $callback
     * @return mixed
     * @internal param array $credentials
     */
    public function verify($token, Closure $callback)
    {
        // If the responses from the validate method is not a user instance, we will
        // assume that it is a redirect and simply return it from this method and
        // the user is properly redirected having an error message on the post.
        $user = $this->validateVerify($token);

        if (! $user instanceof CanVerifyUserContract) {
            return $user;
        }

        // Once we have called this callback, we will remove this token row from the
        // table and return the response from this callback so the user gets sent
        // to the destination given by the developers from the callback return.
        call_user_func($callback, $user);

        $this->tokens->delete($token);

        return VerifyUserBrokerContract::USER_VERIFIED;
    }

    /**
     * Validate a verify account request for the given credentials.
     *
     * @param  $token
     * @return \Wooter\Wooter\Contracts\Auth\CanVerifyUser
     */
    protected function validateVerify($token)
    {
        if (is_null($user = $this->getUserByToken($token))) {
            return VerifyUserBrokerContract::INVALID_TOKEN;
        }

        return $user;
    }

    /**
     * Get the user for the given credentials.
     *
     * @param  array  $credentials
     * @return \Wooter\Wooter\Contracts\Auth\CanVerifyUser
     *
     * @throws \UnexpectedValueException
     */
    public function getUser(array $credentials)
    {
        $credentials = array_except($credentials, ['token']);

        $user = $this->users->retrieveByCredentials($credentials);

        if ($user && ! $user instanceof CanVerifyUserContract) {
            throw new UnexpectedValueException('User must implement CanVerifyUser interface.');
        }

        return $user;
    }

    public function getUserByToken($token)
    {
        $userVerification = UserVerification::whereToken($token)->first();
        if ($userVerification) {
            return $userVerification->user;
        }
    }

    /**
     * Get the verify user token repository implementation.
     *
     * @return \Wooter\Wooter\Auth\VerifyUser\\TokenRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->tokens;
    }
}
