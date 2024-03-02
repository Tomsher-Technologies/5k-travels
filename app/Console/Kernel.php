<?php

namespace App\Console;

use App\Models\ExchangeRate;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $url = 'https://api.currencybeacon.com/v1/convert';
        $schedule->call(function ($url) {
            $rates = ExchangeRate::all();
            foreach ($rates as $rate) {
                $data = [
                    'from' => $rate->from,
                    'to' => $rate->to,
                    'amount' => 1,
                    'api_key' => env('CURRENCY_API_KEY')
                ];
                $response = Http::timeout(300)->withOptions(['verify' => false])
                    ->get($url, $data);

                $apiResult = $response->json();
                if ($apiResult && isset($apiResult['meta']['code']) && $apiResult['meta']['code'] == 200) {
                    $rate->rate =  number_format((float)$apiResult['value'], 10, '.', '');
                    $rate->save();
                }
            }
        })->everySixHours();

        // $schedule->command('queue:work --stop-when-empty')
        //     ->everyMinute()
        //     ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
