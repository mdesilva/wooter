<?php

namespace Wooter\Commands\Search;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\Organization\League\SearchLeaguesCommand;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\SportRepository;

class SearchSportsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $name;

    /**
     * Create a new command instance.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Execute the command.
     *
     * @param SportRepository $sportRepository
     */
    public function handle(SportRepository $sportRepository)
    {
        $params = [
            'name' => $this->name
        ];

        return $sportRepository->search($params);
    }
}
