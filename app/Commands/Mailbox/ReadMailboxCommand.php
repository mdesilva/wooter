<?php

namespace Wooter\Commands\Wooter\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class ReadMailboxCommand extends Command implements SelfHandling
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
    public function handle()
    {
        //
    }
}
