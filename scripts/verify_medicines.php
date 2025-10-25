<?php
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$medicines = \App\Models\Medicine::orderBy('therapy_class')
    ->orderBy('sub_therapy_class')
    ->orderBy('name')
    ->take(5)
    ->get();

foreach ($medicines as $medicine) {
    echo $medicine->therapy_class . ' | ' . 
         $medicine->sub_therapy_class . ' | ' . 
         $medicine->name . "\n";
}

echo "\nTotal medicines in database: " . \App\Models\Medicine::count() . "\n";