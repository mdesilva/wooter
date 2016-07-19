<?php

namespace Wooter\Commands\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Wooter\UserRole;
use Wooter\FirstSetup;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Command;
use Wooter\Commands\Mailbox\CreateMailboxCommand;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Role;
use Wooter\User;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateUserCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
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
    private $email;
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
    private $preselected_role;
    /**
     * @var
     */
    private $day;
    /**
     * @var
     */
    private $month;
    /**
     * @var
     */
    private $year;
    /**
     * @var
     */
    private $jersey;

    /**
     * Create a new command instance.
     *
     * @param      $email
     * @param      $phone
     * @param      $password
     * @param      $day
     * @param      $month
     * @param      $year
     * @param      $gender
     * @param      $first_name
     * @param      $last_name
     * @param      $jersey
     * @param      $preselected_role
     */
    public function __construct($email, $phone, $password, $day = null, $month = null, $year = null, $gender = 'male', $first_name, $last_name, $jersey, $preselected_role = Role::PLAYER)
    {
        $this->phone = $phone;
        $this->password = $password;
        $this->email = $email;
        $this->gender = $gender;
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->preselected_role = $preselected_role;
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->jersey = $jersey;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     * @return string
     */
    public function handle(UserRepository $userRepository)
    {
        $user = DB::transaction(function () use ($userRepository) {

            if (is_null($this->day) || is_null($this->month) || is_null($this->year)) {
                $birthday = null;
            } else {
                $birthday = new Carbon($this->day . '-' . $this->month . '-' . $this->year);
            }

            $user = new User;
            $user->first_name = $this->firstName;
            $user->last_name = $this->lastName;
            $user->email = $this->email;
            $user->password = bcrypt($this->password);
            $user->gender = $this->gender;
            $user->birthday = $birthday;
            $user->phone = $this->phone;
            $user->facebook_integrated = 0;
            $user->preselected_role = $this->preselected_role;

            $userRepository->create($user);

            $role = new UserRole();
            $role->user_id = $user->id;
            $role->role_id = $user->preselected_role;
            $role->save();

            if($user->preselected_role == Role::ORGANIZATION){
                $firstSetup = new FirstSetup;
                $firstSetup->user_id = $user->id;
                $firstSetup->save();
            }

            $this->dispatchFromArray(CreateMailboxCommand::class, ['userId' => $user->id, 'userType' => 'WooterUser']);

            return $user;
        });


        return $user;
    }
}
