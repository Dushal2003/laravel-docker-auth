<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register Artisan commands that aren’t auto‑discovered.
     *
     * @var array<int, class-string>
     */
    protected $commands = [
        // 👇 add your smoke‑test here
        \App\Console\Commands\JwtSmokeTest::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Load routes/console.php and command auto‑discovery.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
