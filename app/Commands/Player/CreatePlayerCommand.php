<?php

namespace Wooter\Commands\Player;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Events\Player\PlayerWasCreatedEvent;
use Wooter\Role;
use Wooter\User;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Event;
use Faker\Factory as FakerFactory;

class CreatePlayerCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

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
     * @var
     */
    private $leagueId;
    /**
     * @var null
     */
    private $teamId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param      $user_id
     * @param      $email
     * @param      $phone
     * @param      $birthday
     * @param      $gender
     * @param      $first_name
     * @param      $last_name
     * @param      $league_id
     * @param null $team_id
     */
    public function __construct($user_id, $email, $phone, $birthday, $gender, $first_name, $last_name, $league_id = null, $team_id = null)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->birthday = $birthday;
        $this->gender = $gender;
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->leagueId = $league_id;
        $this->teamId = $team_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository   $userRepository
     *
     * @param LeagueRepository $leagueRepository
     *
     * @param TeamRepository   $teamRepository
     *
     * @return User
     */
    public function handle(UserRepository $userRepository, LeagueRepository $leagueRepository, TeamRepository $teamRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);
        $team = $teamRepository->getById($this->teamId);
        $player = $userRepository->getByPhone($this->phone);

        if ( ! $player) {
            $player = $userRepository->getByEmail($this->email);
        }

        if ( ! $player) {
            $birthday = new Carbon($this->birthday);

            $player = new User;
            $player->first_name = $this->firstName;
            $player->last_name = $this->lastName;
            $player->email = $this->email;
            $player->gender = $this->gender;
            $player->birthday = $birthday;
            $player->phone = $this->phone;
            $player->facebook_integrated = 0;
            $player->preselected_role = Role::PLAYER;

            $userRepository->create($player);

            Event::fire(new PlayerWasCreatedEvent($player));
        }

        if ($league) {
            $this->dispatchFromArray(CreatePlayerLeagueCommand::class, ['league_id' => $league->id, 'player_id' => $player->id]);
        }

        if ($team) {
            $this->dispatchFromArray(CreatePlayerTeamCommand::class, ['user_id' => $this->userId,'league_id' => $league->id, 'team_id' => $team->id, 'player_id' => $player->id]);
        }

        return $player;
    }
}
