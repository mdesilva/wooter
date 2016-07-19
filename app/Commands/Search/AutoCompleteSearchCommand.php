<?php

namespace Wooter\Commands\Search;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\Organization\League\SearchLeaguesCommand;
use Illuminate\Foundation\Bus\DispatchesJobs;

class AutoCompleteSearchCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    const MAX_NUMBER_RESULTS = 5;

    /**
     * @var
     */
    private $search;

    /**
     * Create a new command instance.
     *
     * @param $search
     */
    public function __construct($search)
    {
        $this->search = $search;
    }

    /**
     * Execute the command.
     *
     */
    public function handle()
    {
        $results = [];

        $maxNumberResults = self::MAX_NUMBER_RESULTS;

        $sports = $this->dispatchFromArray(SearchSportsCommand::class, ['name' => $this->search]);
        $leagues = $this->dispatchFromArray(SearchLeaguesCommand::class, ['name' => $this->search]);

        foreach ($sports as $sport) {
            if ($maxNumberResults === 0) {
                break;
            }
            $maxNumberResults--;

            $results[] = [
                'type' => 'sport',
                'id' => $sport->id,
                'name' => $sport->name,
            ];
        }

        foreach ($leagues as $league) {
            if ($maxNumberResults === 0) {
                break;
            }
            $maxNumberResults--;

            $results[] = [
                'type' => 'league',
                'id' => $league->id,
                'name' => $league->name,
            ];
        }

        return $results;
    }
}
