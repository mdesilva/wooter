<?php

namespace Wooter\Console\Commands\Angular;

use Illuminate\Console\Command;
use Wooter\Wooter\ngTools\ngViewCleaner;

class ViewCaching extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ng:view-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a json file with devices for each view. * Important *';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $plugin = new ngViewCleaner();
        $comm = ($plugin->caching())?'    Successful caching':'    Sorry i think we have a problem, contact me Alinus (skype: alin.designstudio)';
        $this->comment(PHP_EOL.$comm.PHP_EOL);
    }
}
