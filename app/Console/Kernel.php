<?php

use App\Http\Controllers\CryptoController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $controller = new CryptoController();
            request()->merge(['crypto' => 'BTC']); // Simula un request
            $controller->getChartData(request());
        })->everyFiveMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
