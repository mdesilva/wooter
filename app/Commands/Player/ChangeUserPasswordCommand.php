<?php

namespace Wooter\Commands\Player;

use Illuminate\Support\Facades\Hash;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerConfirmPasswordIncorrectException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerWrongPasswordException;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;

class ChangeUserPasswordCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $oldPassword;
    /**
     * @var
     */
    private $newPassword;
    /**
     * @var
     */
    private $confirmPassword;

    /**
     * Create a new command instance.
     *
     * @param $player_id
     * @param $old_password
     * @param $new_password
     * @param $confirm_password
     */
    public function __construct($player_id, $old_password, $new_password, $confirm_password)
    {
        $this->playerId = $player_id;
        $this->oldPassword = $old_password;
        $this->newPassword = $new_password;
        $this->confirmPassword = $confirm_password;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @return bool
     * @throws NotPermissionException
     * @throws PlayerConfirmPasswordIncorrectException
     * @throws PlayerNotFound
     * @throws PlayerWrongPasswordException
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository)
    {
        $player = $userRepository->getById($this->playerId);

        if ( ! $player) {
            throw new PlayerNotFound;
        }

        if ( ! Hash::check($this->oldPassword, $player->password)) {
            throw new PlayerWrongPasswordException;
        }

        if ($this->newPassword !== $this->confirmPassword) {
            throw new PlayerConfirmPasswordIncorrectException;
        }

        $player->password = bcrypt($this->newPassword);

        $userRepository->update($player);

        return true;
    }
}
