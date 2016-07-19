<?php

namespace Wooter\Commands\Stage\Regular;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularStageNotFound;
use Wooter\Wooter\Repositories\Stage\Regular\RegularCompetitionWeeksRepository;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\CompetitionWeek;

class CreateRegularCompetitionWeekCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $startsAt;
    /**
     * @var
     */
    private $endsAt;
    /**
     * @var
     */
    private $regularId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $regular_id
     * @param $name
     * @param $starts_at
     * @param $ends_at
     */
    public function __construct($user_id, $regular_id, $name, $starts_at, $ends_at)
    {
        $this->userId = $user_id;
        $this->name = $name;
        $this->startsAt = $starts_at;
        $this->endsAt = $ends_at;
        $this->regularId = $regular_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                    $userRepository
     * @param RegularStageRepository            $regularStageRepository
     * @param RegularCompetitionWeeksRepository $regularCompetitionWeeksRepository
     *
     * @return CompetitionWeek
     * @throws RegularStageNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository,
                           RegularStageRepository $regularStageRepository,
                           RegularCompetitionWeeksRepository $regularCompetitionWeeksRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        $regular = $regularStageRepository->getById($this->regularId);

        if (!$regular) {
            throw new RegularStageNotFound;
        }
        
        $competitionWeek = new CompetitionWeek();
        
        $competitionWeek->stage_id = $this->regularId;
        $competitionWeek->stage_type = RegularStage::class;
        $competitionWeek->name = $this->name;
        $competitionWeek->starts_at = $this->startsAt;
        $competitionWeek->ends_at = $this->endsAt;
        
        $regularCompetitionWeeksRepository->create($competitionWeek);
        
        return $competitionWeek;
    }
}


