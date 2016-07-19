<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueVideoLabel;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoLabelRepository;


class CreateLeagueVideoLabelsCommand extends Command implements SelfHandling
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($league_id, $label_name, $user_id)
    {
        $this->leagueId = $league_id;
        $this->label_name = $label_name;
        $this->userId = $user_id;
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

        $leagueVideoLabel = new LeagueVideoLabel();
        $leagueVideoLabel->label_name = $this->label_name;
        $leagueVideoLabel->league_id = $this->leagueId;

        $leagueVideoLabelRepository->create($leagueVideoLabel);

        $labels = $leagueVideoLabelRepository->getFromLeagueId($this->leagueId);

        return $labels;


    }
}
