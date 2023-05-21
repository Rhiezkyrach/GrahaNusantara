<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        //update data corona setiap jam 19:00 dan 02:00
        $schedule->call(function () {
            $url="https://data.covid19.go.id/public/api/update.json";
            $result = file_get_contents($url);
            $datakawal = json_decode($result, true);

            $data["positif"] = $datakawal["update"]["total"]["jumlah_positif"];
            $data["meninggal"] = $datakawal["update"]["total"]["jumlah_meninggal"];
            $data["sembuh"] = $datakawal["update"]["total"]["jumlah_sembuh"];
            $data["updated"] = $datakawal["update"]["penambahan"]["created"];
            $data["updated_at"] = now()->translatedFormat( 'Y-m-d H:i:s');

            DB::table('widget_corona')->where('id', 1)->update($data);
        })->twiceDaily(19, 2);
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
