<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Orangtua;
use Illuminate\Support\Facades\Hash;

echo "Mereset TOTAL data login orang tua...\n";

$ortus = Orangtua::with('siswa')->get();
$count = 0;

foreach ($ortus as $ortu) {
    if (!$ortu->siswa) {
        echo "Skip: No siswa for {$ortu->nama}\n";
        continue;
    }

    $nis = $ortu->siswa->nis;
    $namaSiswa = strtolower(trim($ortu->siswa->nama));
    $namaDepan = explode(' ', $namaSiswa)[0];
    
    // Kita gunakan format namadepan.nis saja agar simpel
    $newUsername = $namaDepan . '.' . $nis;
    
    // Jika ada ayah dan ibu, kita beri akhiran agar username unik di database
    $hubungan = strtolower($ortu->hubungan);
    if (strpos($hubungan, 'ayah') !== false) {
        $newUsername = $namaDepan . '.' . $nis . '.ayah';
    } elseif (strpos($hubungan, 'ibu') !== false) {
        $newUsername = $namaDepan . '.' . $nis . '.ibu';
    }

    $ortu->password = Hash::make('ortu123');
    $ortu->username = $newUsername;
    $ortu->save();

    echo "RESET: {$ortu->hubungan} - {$namaSiswa} -> User: {$newUsername} | Pass: ortu123\n";
    $count++;
}

echo "\nBERHASIL! {$count} akun telah di-reset total.\n";
