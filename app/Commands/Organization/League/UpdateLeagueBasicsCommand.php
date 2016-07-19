<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateImageCommand;
use Wooter\Commands\DeleteImageCommand;
use Wooter\Commands\UpdateImageCommand;
use Wooter\LeagueOrganization;
use Wooter\Wooter\Exceptions\Organization\League\LeagueBasicsNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueBasicsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class UpdateLeagueBasicsCommand extends Command implements SelfHandling
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
     * @var
     */
    private $logo;

    /**
     * Create a new command instance.
     *
     * @param      $user_id
     * @param      $league_id
     * @param      $min_age
     * @param      $max_age
     * @param      $gender
     * @param null $logo
     */
    public function __construct($user_id, $league_id, $min_age, $max_age, $gender, $logo = null)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->minAge = $min_age;
        $this->maxAge = $max_age;
        $this->gender = $gender;
        $this->logo = $logo;
    }

    /**
     * Tries to create a league and save it in DB
     *
     * @param LeagueRepository       $leagueRepository
     *
     * @param LeagueBasicsRepository $leagueBasicsRepository
     *
     * @return bool
     * @throws LeagueNotBelongToUser
     * @throws LeagueNotFound
     * @internal param LeagueBasicsRepository $leagueBasicsRepository
     */
    public function handle(LeagueRepository $leagueRepository, LeagueBasicsRepository $leagueBasicsRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if ($this->logo instanceof UploadedFile) {
            if ($league->basics->logo) {
                $this->dispatchFromArray(DeleteImageCommand::class, ['image_id' => $league->basics->logo_id]);
            }
            $logo = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $this->logo, 'prefix' => LeagueOrganization::LOGO_PREFIX, 'description' => LeagueOrganization::LOGO_DESCRIPTION]);
            $league->basics->logo_id = $logo->id;
        }

        $league->basics->min_age = $this->minAge;
        $league->basics->max_age = $this->maxAge;
        $league->basics->gender = $this->gender;

        $leagueBasicsRepository->update($league->basics);

        return $league->basics->fresh();
    }
}
