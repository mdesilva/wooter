<?php
/**
 * Created by PhpStorm.
 * User: carlosmoralescliment
 * Date: 09/02/16
 * Time: 22:57
 */

namespace Wooter\Wooter\Repositories;

use Carbon\Carbon;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Str;
use Wooter\Wooter\Contracts\Auth\CanVerifyUser as CanVerifyUserContract;
use Wooter\Wooter\Contracts\Auth\TokenRepositoryContract;

class UserTokenRepository implements TokenRepositoryContract
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * The token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The hashing key.
     *
     * @var string
     */
    protected $hashKey;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new token repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface $connection
     * @param  string $table
     * @param  string $hashKey
     * @param  int $expires
     */
    public function __construct(ConnectionInterface $connection, $table, $hashKey, $expires = 60)
    {
        $this->table = $table;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->connection = $connection;
    }

    /**
     * Create a new token record.
     *
     * @param CanVerifyUserContract  $user
     * @return string
     */
    public function create(CanVerifyUserContract $user)
    {
        $email = $user->getEmailForVerifyUser();

        $this->deleteExisting($user);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the verify the user. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $token = $this->createNewToken();

        $this->getTable()->insert($this->getPayload($user->id, $email, $token));

        return $token;
    }

    /**
     * Delete all existing verify user tokens from the database.
     *
     * @param  CanVerifyUserContract  $user
     * @return int
     */
    protected function deleteExisting(CanVerifyUserContract $user)
    {
        return $this->getTable()->where('email', $user->getEmailForVerifyUser())->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param $userId
     * @param  string $email
     * @param  string $token
     * @return array
     */
    protected function getPayload($userId, $email, $token)
    {
        return ['user_id' => $userId, 'email' => $email, 'token' => $token, 'created_at' => new Carbon];
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  CanVerifyUserContract  $user
     * @param  string  $token
     * @return bool
     */
    public function exists(CanVerifyUserContract $user, $token)
    {
        $email = $user->getEmailForVerifyUser();

        $token = (array) $this->getTable()->where('email', $email)->where('token', $token)->first();

        return $token && ! $this->tokenExpired($token);
    }

    /**
     * Determine if the token has expired.
     *
     * @param  array  $token
     * @return bool
     */
    protected function tokenExpired($token)
    {
        $expirationTime = strtotime($token['created_at']) + $this->expires;

        return $expirationTime < $this->getCurrentTime();
    }

    /**
     * Get the current UNIX timestamp.
     *
     * @return int
     */
    protected function getCurrentTime()
    {
        return time();
    }

    /**
     * Delete a token record by token.
     *
     * @param  string  $token
     * @return void
     */
    public function delete($token)
    {
        $this->getTable()->where('token', $token)->delete();
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    /**
     * Begin a new database query against the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getTable()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Get the database connection instance.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
