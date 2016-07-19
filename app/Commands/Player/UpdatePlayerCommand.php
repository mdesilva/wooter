<?php

namespace Wooter\Commands\Player;

use Carbon\Carbon;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\User;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdatePlayerCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $phone;
    /**
     * @var
     */
    private $password;
    /**
     * @var
     */
    private $birthday;
    /**
     * @var
     */
    private $gender;
    /**
     * @var
     */
    private $firstName;
    /**
     * @var
     */
    private $lastName;
    /**
     * @var null
     */
    private $leagueId;

    /**
     * Create a new command instance.
     *
     * @param      $player_id
     * @param      $email
     * @param      $phone
     * @param      $password
     * @param      $birthday
     * @param      $gender
     * @param      $first_name
     * @param      $last_name
     * @param null $league_id
     */
    public function __construct($player_id, $email, $phone, $password, $birthday, $gender, $first_name, $last_name, $league_id = null)
    {
        $this->playerId = $player_id;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->birthday = $birthday;
        $this->gender = $gender;
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->leagueId = $league_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $playerRepository
     *
     * @return User
     * @throws PlayerNotFound
     * @internal param AwardRepository $awardRepository
     * @internal param UserRepository $userRepository
     */
    public function handle(UserRepository $playerRepository)
    {
        $player = $playerRepository->getById($this->playerId);

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }

        $birthday = new Carbon($this->birthday);

        $player->first_name = $this->firstName;
        $player->last_name = $this->lastName;
        $player->email = $this->email;
        $player->gender = $this->gender;
        $player->birthday = $birthday;
        $player->phone = $this->phone;

        $playerRepository->update($player);

        return $player;
    }
}
