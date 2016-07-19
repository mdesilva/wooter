<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\ScheduleDemoRepository;

class ReadScheduleDemoCommand extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(ScheduleDemoRepository $scheduleDemoRepository)
    {
        return $scheduleDemoRepository->all();
    }
}
