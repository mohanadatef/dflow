<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Acl\Console\Commands\CheckOnline;
use Modules\Acl\Console\Commands\CompaniesImport;
use Modules\Acl\Console\Commands\ResearcherSchedule8;
use Modules\Acl\Console\Commands\ResearcherSchedule5;
use Modules\Acl\Console\Commands\TransferLogs;
use Modules\Basic\Console\GenerateSeeders;
use Modules\Record\Console\Commands\ImportRecords;

class Kernel extends ConsoleKernel
{
    /**
     * @Target GenerateSeeders command to run seeder and save in database
     * @Target timeOutAd command to check time ad and make it un active
     * @Target timeOutTask command to check time task and make it un active
     * @Target timeOutOffer command to check time offer and make it un active
     */
    protected $commands = [
        GenerateSeeders::class,
        ImportRecords::class,
        CompaniesImport::class,
        TransferLogs::class,
        CheckOnline::class,
        ResearcherSchedule8::class,
        ResearcherSchedule5::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     * check setting value if it has time will run every minute but if 0 will not work
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('log:transfer')->dailyAt('08:59');
        $schedule->command('researcher:schedule8')->dailyAt('08:45');
        $schedule->command('researcher:schedule5')->dailyAt('17:45');
        $schedule->command('onlineusers:check')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
