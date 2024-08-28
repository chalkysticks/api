<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\Tv;

// * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

Artisan::command('inspire', function () {
	$this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Check for live videos
Schedule::command(Tv\FetchLive::class, ['--create=true'])->everyFiveMinutes();

// Check for new videos
Schedule::command(Tv\Fetch::class, ['--create=true'])->everyHour();

// Check all URLs once a day
Schedule::command(Tv\Check::class, ['--all=true'])->weekly();
