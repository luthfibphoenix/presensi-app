<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Orangtua;
use Illuminate\Support\Facades\Hash;

echo "Memulai sinkronisasi password orang tua (Format Simpel)...\n";

$ortus = Orangtua::with('siswa')->get();
$count = 0;

foreach ($ortus as $ortu) {
    if (!$ortu->siswa) continue;

    $nis = $ortu->siswa->nis;
    $suffix = '000'; // fallback
    
    $hubungan = strtolower($ortu->hubungan);
    if (strpos($hubungan, 'ayah') !== false) $suffix = '111';
    elseif (strpos($hubungan, 'ibu') !== false) $suffix = '222';
    elseif (strpos($hubungan, 'wali') !== false) $suffix = '333';

    $newPassword = $nis . $suffix;
    
    $ortu->update([
        'password' => Hash::make($newPassword),
        'username' => $nis . '_' . $suffix
    ]);

    echo "Update: {$ortu->hubungan} - NIS: {$nis} -> Password: {$newPassword}\n";
    $count++;
}

echo "\nSelesai! {$count} akun orang tua telah diperbarui dengan format simpel.\n";
