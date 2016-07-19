<?php

namespace Wooter\Commands\Admin;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateAdminUrlCommand extends Command implements SelfHandling
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
        $code = md5(date('Y-m-d'));

        return $code;
    }
}
