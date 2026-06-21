<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Orangtua;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

echo "Memulai sinkronisasi password orang tua...\n";

$ortus = Orangtua::with('siswa')->get();
$count = 0;

foreach ($ortus as $ortu) {
    if (!$ortu->siswa) {
        echo "Skip: Ortu {$ortu->nama} tidak punya data siswa.\n";
        continue;
    }

    $nis = $ortu->siswa->nis;
    $suffix = 'ortu'; // default
    
    $hubungan = strtolower($ortu->hubungan);
    if (strpos($hubungan, 'ayah') !== false) $suffix = 'ayah';
    elseif (strpos($hubungan, 'ibu') !== false) $suffix = 'ibu';
    elseif (strpos($hubungan, 'wali') !== false) $suffix = 'wali';

    $newPassword = $nis . $suffix;
    
    $ortu->update([
        'password' => Hash::make($newPassword),
        'username' => $nis . '_' . $suffix // Update username juga agar unik
    ]);

    echo "Update: {$ortu->hubungan} - Siswa: {$nis} -> Password: {$newPassword}\n";
    $count++;
}

echo "\nSelesai! {$count} akun orang tua telah diperbarui.\n";
echo "Silakan coba login dengan:\n";
echo "Username: [NIS Siswa]\n";
echo "Password: [NIS]ayah atau [NIS]ibu\n";
