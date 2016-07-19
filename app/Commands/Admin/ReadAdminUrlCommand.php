<?php

namespace Wooter\Commands\Admin;
use Hash;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class ReadAdminUrlCommand extends Command implements SelfHandling
{
    private $code;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        // die($code);
        $this->code = $code;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $date = date('Y-m-d');
        if (md5($date) == $this->code) {
            return true;
        } 

        return false;
    }
}
