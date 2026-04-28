<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Mapel;

$user = User::where('username', 'Slamet')->first();
if ($user) {
    echo "User: {$user->fullname} (ID: {$user->id})\n";
    $jadwals = Jadwal::where('user_id', $user->id)->get();
    if ($jadwals->isEmpty()) {
        echo "No schedules found for this user.\n";
    } else {
        echo "Schedules found:\n";
        foreach ($jadwals as $j) {
            $mapel = Mapel::find($j->mapel_id);
            echo "- Mapel: " . ($mapel->nama_mapel ?? 'Unknown') . " | Kelas ID: {$j->kelas_id}\n";
        }
    }
} else {
    echo "User not found.\n";
}
