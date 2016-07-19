<?php

namespace Wooter\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Wooter\Console\Commands\Inspire::class,
        \Wooter\Console\Commands\Env::class,
        \Wooter\Console\Commands\Angular\ngController::class,
        \Wooter\Console\Commands\Angular\ngFactory::class,
        \Wooter\Console\Commands\Angular\ngDirective::class,
        \Wooter\Console\Commands\Angular\appFunction::class,
        \Wooter\Console\Commands\Angular\appStyle::class,
        \Wooter\Console\Commands\Angular\ViewCaching::class,
        \Wooter\Console\Commands\Angular\AppCaching::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
