<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoLabelRepository;

class UpdateLeagueVideoLabelsCommand extends Command implements SelfHandling
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
    public function __construct($league_id, $label_name, $user_id, $id)
    {
        $this->leagueId = $league_id;
        $this->label_name = $label_name;
        $this->userId = $user_id;
        $this->label_id = $id;
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
        $labelModel->label_name = $this->label_name;

        $leagueVideoLabelRepository->update($labelModel);

        $labels = $leagueVideoLabelRepository->getFromLeagueId($this->leagueId);

        return $labels;
    }
}
