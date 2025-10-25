<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register medicines sync command
use App\Console\Commands\SyncMedicinesCsv;

// Register medicines sync as an artisan command via a closure so it works
Artisan::command('medicines:sync-csv {--prune}', function () {
    $cmd = app()->make(SyncMedicinesCsv::class);
    $cmd->setLaravel(app());
    // call runner with output and prune flag
    return $cmd->runFromConsole($this->getOutput(), $this->option('prune'));
})->describe('Sync medicines table with the CSV file');
