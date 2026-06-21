<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Orangtua;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

echo "Memulai sinkronisasi username (namadepan.nis) dan password (ortu123)...\n";

$ortus = Orangtua::with('siswa')->get();
$count = 0;

foreach ($ortus as $ortu) {
    if (!$ortu->siswa) continue;

    $nis = $ortu->siswa->nis;
    $namaSiswa = strtolower($ortu->siswa->nama);
    $namaDepan = explode(' ', $namaSiswa)[0];
    
    $hubungan = strtolower($ortu->hubungan);
    $prefix = '';
    if (strpos($hubungan, 'ayah') !== false) $prefix = 'ayah.';
    elseif (strpos($hubungan, 'ibu') !== false) $prefix = 'ibu.';
    else $prefix = 'wali.';

    $newUsername = $prefix . $namaDepan . '.' . $nis;
    $newPassword = 'ortu123';
    
    $ortu->update([
        'username' => $newUsername,
        'password' => Hash::make($newPassword)
    ]);

    echo "Update: {$ortu->hubungan} -> User: {$newUsername} | Pass: {$newPassword}\n";
    $count++;
}

echo "\nSelesai! {$count} akun telah diperbarui.\n";
