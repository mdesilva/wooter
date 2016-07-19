<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateImageCommand;
use Wooter\LeagueBasics;
use Wooter\LeagueOrganization;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueBasicsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class CreateLeagueBasicsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $userId;
    
    /**
     * @var
     */
    private $leagueId;
    
    /**
     * @var
     */
    private $minAge;
    /**
     * @var
     */
    private $maxAge;
    /**
     * @var
     */
    private $gender;
    /**
     * @var null
     */
    private $logo;

    /**
     * Create a new command instance.
     *
     *
     * @internal param $age
     *
     * @param      $user_id
     * @param      $league_id
     * @param null $logo
     * @param      $min_age
     * @param      $max_age
     * @param      $gender
     */
    public function __construct($user_id, $league_id, $logo = null, $min_age, $max_age, $gender)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->minAge = $min_age;
        $this->maxAge = $max_age;
        $this->gender = $gender;
        $this->logo = $logo;
    }

    /**
     * Execute the command.
     *
     * @param LeagueBasicsRepository $leagueBasicsRepository
     * @param LeagueRepository $leagueRepository
     * @return string|LeagueBasics
     * @throws LeagueNotBelongToUser
     * @throws LeagueNotFound
     */
    public function handle(LeagueBasicsRepository $leagueBasicsRepository, LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }
        
        $leagueBasics = new LeagueBasics();

        if ($this->logo instanceof UploadedFile) {
            $logo = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $this->logo, 'description' => LeagueOrganization::LOGO_DESCRIPTION, 'prefix' => LeagueOrganization::LOGO_PREFIX]);
            $leagueBasics->logo_id = $logo->id;
        }

        $leagueBasics->league_id = $this->leagueId;
        $leagueBasics->min_age = $this->minAge;
        $leagueBasics->max_age = $this->maxAge;
        $leagueBasics->gender = $this->gender;

        $leagueBasicsRepository->create($leagueBasics);

        return $leagueBasics;
    }
}
