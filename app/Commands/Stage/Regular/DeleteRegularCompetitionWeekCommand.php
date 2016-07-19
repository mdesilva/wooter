<?php

namespace Wooter\Commands\Stage\Regular;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularCompetitionWeekNotFound;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularStageNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Stage\Regular\RegularCompetitionWeeksRepository;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteRegularCompetitionWeekCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $regularId;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $competitionWeekId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $regular_id
     * @param $competition_week_id
     */
    public function __construct($user_id, $regular_id, $competition_week_id)
    {
        $this->regularId = $regular_id;
        $this->userId = $user_id;
        $this->competitionWeekId = $competition_week_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                    $userRepository
     * @param RegularStageRepository            $RegularStageRepository
     *
     * @param RegularCompetitionWeeksRepository $regularCompetitionWeeksRepository
     *
     * @return
     * @throws RegularCompetitionWeekNotFound
     * @throws RegularStageNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, RegularStageRepository $RegularStageRepository, RegularCompetitionWeeksRepository $regularCompetitionWeeksRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        $regular = $RegularStageRepository->getById($this->regularId);

        if ( ! $regular) {
            throw new RegularStageNotFound;
        }

        $competitionWeekId = $regularCompetitionWeeksRepository->getById($this->competitionWeekId);

        if ( ! $competitionWeekId) {
            throw new RegularCompetitionWeekNotFound;
        }

        return $competitionWeekId->delete();
    }
}

