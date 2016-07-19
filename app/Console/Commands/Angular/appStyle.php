<?php

namespace Wooter\Console\Commands\Angular;

use Illuminate\Console\Command;
use Wooter\Wooter\ngTools\ngTools;

class appStyle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:style {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an App style';

    protected $ngTools;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->ngTools = new ngTools();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $this->comment(PHP_EOL.$this->ngTools->appStyle($this->argument('name')).PHP_EOL);
    }
}
