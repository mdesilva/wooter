<?php

namespace Wooter\Commands\Player;

use Carbon\Carbon;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerEmailAlreadyExistsException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdatePlayerInfoCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $firstName;
    /**
     * @var
     */
    private $lastName;
    /**
     * @var
     */
    private $phone;
    /**
     * @var null
     */
    private $birthday;
    /**
     * @var null
     */
    private $state;
    /**
     * @var null
     */
    private $school;
    /**
     * @var
     */
    private $playerId;
    /**
     * @var null
     */
    private $gender;

    /**
     * Create a new command instance.
     *
     * @param      $player_id
     * @param      $email
     * @param      $first_name
     * @param      $last_name
     * @param      $phone
     * @param null $birthday
     * @param null $city
     * @param null $state
     * @param null $school
     * @param null $gender
     */
    public function __construct($player_id, $email, $first_name, $last_name, $phone, $birthday = null, $city = null, $state = null, $school = null, $gender = null)
    {
        $this->playerId = $player_id;
        $this->email = $email;
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->phone = $phone;
        $this->birthday = $birthday;
        $this->city = $city;
        $this->state = $state;
        $this->school = $school;
        $this->gender = $gender;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @return \Wooter\User
     * @throws NotPermissionException
     * @throws PlayerEmailAlreadyExistsException
     * @throws PlayerNotFound
     */
    public function handle(UserRepository $userRepository)
    {
        $player = $userRepository->getById($this->playerId);

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }

        if ($this->email !== $player->email) {

            $userWithEmailExists = $userRepository->getByEmail($this->email);

            if ($userWithEmailExists) {
                throw new PlayerEmailAlreadyExistsException;
            }

            $player->email = $this->email;
        }

        if ($this->birthday) {
            $birthday = new Carbon($this->birthday);
            $player->birthday = $birthday;
        }

        if ($this->city) {
            $player->city = $this->city;
        }

        if ($this->state) {
            $player->state = $this->state;
        }

        if ($this->school) {
            $player->school = $this->school;
        }

        if ($this->gender) {
            $player->gender = $this->gender;
        }

        $player->first_name = $this->firstName;
        $player->last_name = $this->lastName;
        $player->phone = $this->phone;

        $userRepository->update($player);

        return $player;
    }
}
