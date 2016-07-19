<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\Notifications\SendEmailPlayerAddedToLeagueCommand;
use Wooter\Commands\Notifications\SendEmailToPlayerAddedToLeagueCommand;
use Wooter\Commands\Notifications\SendEmailToPlayerCreatedAndAddedToLeagueCommand;
use Wooter\Commands\Notifications\SendSMSToPlayerAddedToLeagueCommand;
use Wooter\Commands\Notifications\SendSMSToPlayerCreatedAndAddedToLeagueCommand;
use Wooter\Role;
use Wooter\User;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyExistsInLeagueException;
use Wooter\Wooter\Exceptions\Player\PlayerEmailAlreadyExistsException;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use DB;
use Wooter\Commands\Notifications\SendTwilioSMSPlayerAddedToLeagueCommand;
use Wooter\Commands\User\CreateUserCommand;
use Illuminate\Foundation\Bus;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Contracts\Bus\Dispatcher;
use Wooter\Http\Controllers\API\League\LeaguePlayersController;

class CreateLeaguePlayerCommand extends Command implements SelfHandling
{
        use DispatchesJobs;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $leagueId;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $jersey;
    /**
     * @var
     */
    private $userId;

    /**
     * @param           $league_id
     * @param           $first_name
     * @param           $last_name
     * @param           $user_id
     * @param bool|null $email
     * @param bool|null $phone
     */
    public function __construct($league_id, $first_name, $last_name, $user_id, $jersey, $email = false, $phone = false)
    {
        $this->leagueId = $league_id;
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->userId = $user_id;
        $this->jersey = $jersey;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository         $userRepository
     *
     * @param LeagueRepository       $leagueRepository
     *
     * @param PlayerLeagueRepository $playerLeagueRepository
     *
     * @return mixed
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws PlayerAlreadyExistsInLeagueException
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, LeagueRepository $leagueRepository, PlayerLeagueRepository $playerLeagueRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user)
        {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if (!$league)
        {
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $player = $userRepository->getByEmail($this->email);

        if (!$player)
        {
            $player = $userRepository->getByPhone($this->phone);
        }

        if ( ! $player) {
            $player = $this->dispatchFromArray(CreateUserCommand::class, [
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => User::DEFAULT_PASSWORD,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'jersey' => $this->jersey,
                'preselected_role' => Role::PLAYER,
            ]);

            if ($this->phone)
            {
                $this->dispatchFromArray(SendSMSToPlayerCreatedAndAddedToLeagueCommand::class, ['player' => $player, 'league' => $league]);
            }

            if ($this->email)
            {
                $this->dispatchFromArray(SendEmailToPlayerCreatedAndAddedToLeagueCommand::class, ['player' => $player, 'league' => $league]);
            }

        } else {

            $playerLeague = $playerLeagueRepository->getByPlayerAndLeagueId($player->id, $league->id);

            if ( $playerLeague) {
                throw new PlayerAlreadyExistsInLeagueException;
            }

            if ($this->phone)
            {
                $this->dispatchFromArray(SendSMSToPlayerAddedToLeagueCommand::class,['player' => $player, 'league' => $league]);
            }

            if ($this->email)
            {
                $this->dispatchFromArray(SendEmailToPlayerAddedToLeagueCommand::class,['player' => $player, 'league' => $league]);
            }
        }

        $player->leagues()->attach($this->leagueId);



        return $player;

    }
}
