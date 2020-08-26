<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade john theme to newer
 * versions in the future.
 *
 * @category    John
 * @package     john theme
 * @author      John Nguyen
 * @copyright   Copyright (c) John Nguyen Team
 */ 
namespace App\Console;

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
        \App\Console\Commands\CrawCat::class,
        \App\Console\Commands\FetchCommand::class,
        \App\Console\Commands\Proxy::class,
        \App\Console\Commands\UpdateStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('craw:cat')->everyMinute();
        $schedule->command('proxy:update')->everyMinute();
        $schedule->command('keywords:fetch')->dailyAt('22:10');
        $schedule->command('cat:updatestatus')->dailyAt('23:40');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
