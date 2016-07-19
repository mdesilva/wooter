<?php

namespace Wooter\Console\Commands\Angular;

use Illuminate\Console\Command;
use Wooter\Wooter\Assetic\Loader\AsseticLoader;

class AppCaching extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ng:app-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a json file with app files for production caching. * Important *';

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
       $plugin = new AsseticLoader('*');
       if ($plugin->caching()) {
           $this->comment(PHP_EOL."Successful caching check 'public/config/assets/app.json'".PHP_EOL);
       }
    }
}
