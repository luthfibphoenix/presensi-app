<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$jurnal = App\Models\JurnalMengajar::find(41);
if (!$jurnal) {
    echo "Journal 41 not found!\n";
    exit;
}

echo "Journal ID: " . $jurnal->id . "\n";
echo "Teacher ID: " . $jurnal->user_id . "\n";
$teacher = App\Models\User::find($jurnal->user_id);
echo "Teacher Name: " . ($teacher ? $teacher->fullname : 'NULL') . "\n";
echo "Journal Class: [" . $jurnal->kelas . "]\n";

// Check teacher's scheduled classes
$scheduledClasses = App\Models\Jadwal::where('user_id', $jurnal->user_id)
    ->select('kelas')
    ->distinct()
    ->pluck('kelas')
    ->toArray();

echo "Teacher's Scheduled Classes: " . json_encode($scheduledClasses) . "\n";

if (in_array($jurnal->kelas, $scheduledClasses)) {
    echo "SUCCESS: Journal class IS in teacher's schedule.\n";
} else {
    echo "WARNING: Journal class IS NOT in teacher's schedule!\n";
}
