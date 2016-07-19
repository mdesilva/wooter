<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoLabelRepository;
use Wooter\Wooter\Exceptions\DatabaseException;

class DeleteLeagueVideoLabelsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $label_name;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $lable_id;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($leagueId,  $user_id, $labelId)
    {
        $this->leagueId = $leagueId;

        $this->userId = $user_id;
        $this->label_id = $labelId;
    }


    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeagueRepository $leagueRepository, LeagueVideoLabelRepository $leagueVideoLabelRepository)
    {
        //check league
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }

        $labelModel = $leagueVideoLabelRepository->getById($this->label_id);


        if ( ! $labelModel->delete())
        {

            throw new DatabaseException('There was an error deleting the league basics');
        }


        $labels = $leagueVideoLabelRepository->getFromLeagueId($this->leagueId);

        return $labels;
    }
}
