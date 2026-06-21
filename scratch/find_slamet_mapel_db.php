<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$user_id = 32;
$jadwals = DB::table('jadwals')->where('user_id', $user_id)->get();
$subjects = [];
foreach ($jadwals as $j) {
    if (!empty($j->mata_pelajaran)) {
        $subjects[] = $j->mata_pelajaran;
    }
}

$uniqueSubjects = array_unique($subjects);
if (empty($uniqueSubjects)) {
    echo "No subjects found for user ID {$user_id}.\n";
} else {
    echo "Subjects taught by user ID {$user_id}:\n";
    foreach ($uniqueSubjects as $s) {
        echo "- {$s}\n";
    }
}
