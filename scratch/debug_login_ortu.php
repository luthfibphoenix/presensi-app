<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Siswa;
use App\Models\Orangtua;
use Illuminate\Support\Facades\Hash;

$nisTest = '3864'; // Contoh NIS yang tadi muncul di screenshot
$siswa = Siswa::where('nis', $nisTest)->first();

if (!$siswa) {
    echo "Siswa dengan NIS {$nisTest} tidak ditemukan!\n";
    die();
}

$namaSiswa = $siswa->nama;
$namaDepan = strtolower(explode(' ', trim($namaSiswa))[0]);
$expectedUsername = "{$namaDepan}.{$nisTest}";

echo "Data Siswa Found:\n";
echo "Nama Asli: '{$namaSiswa}'\n";
echo "Nama Depan (Hasil Split): '{$namaDepan}'\n";
echo "Username yang seharusnya diketik: '{$expectedUsername}'\n";

$ortus = Orangtua::where('siswa_id', $siswa->id)->get();
echo "\nData Orang Tua Linked:\n";
foreach ($ortus as $ortu) {
    echo "- {$ortu->hubungan}: Username di DB: '{$ortu->username}' | PW Match 'ortu123': " . (Hash::check('ortu123', $ortu->password) ? 'YES' : 'NO') . "\n";
}
