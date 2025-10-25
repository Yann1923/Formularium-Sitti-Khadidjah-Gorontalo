<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Boot the kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::select("select therapy_class, sub_therapy_class, name from medicines order by therapy_class, sub_therapy_class, name limit 15");
foreach ($rows as $r) {
    echo implode(' | ', [(string)$r->therapy_class, (string)$r->sub_therapy_class, (string)$r->name]) . PHP_EOL;
}
