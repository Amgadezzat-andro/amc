<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class ClearCaches implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Artisan::queue('config:clear');
        $output = Artisan::output();
        echo $output;
        Artisan::queue('cache:clear');
        $output = Artisan::output();
        echo $output;
        Artisan::queue('optimize:clear');
        $output = Artisan::output();
        echo $output;
        Artisan::queue('filament:clear-cached-components');
        $output = Artisan::output();
        echo $output;

        // Artisan::queue('filament:optimize'); //not allowed from console
        // $output = Artisan::output();
        // echo $output;

        Artisan::queue('filament:cache-components');
        $output = Artisan::output();
        echo $output;

        // Artisan::queue('icons:cache'); //not allowed from console
        // $output = Artisan::output();
        // echo $output;
    }
}
