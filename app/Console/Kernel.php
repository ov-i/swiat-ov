<?php

namespace App\Console;

use App\Repositories\Eloquent\Auth\AuthRepository;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    public function __construct(
        \Illuminate\Contracts\Foundation\Application $app,
        \Illuminate\Contracts\Events\Dispatcher $events,
        private readonly AuthRepository $authRepository
    ) {
        parent::__construct($app, $events);
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('telescope:prune')->daily();
        $schedule->command('horizon:snapshot')->hourly();
        $schedule->job(new \App\Jobs\ClearUserBlock($this->authRepository))->everyMinute();
        // $schedule->job(new \App\Jobs\ClearUserBlock())->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
