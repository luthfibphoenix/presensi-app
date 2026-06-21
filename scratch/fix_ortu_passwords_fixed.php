<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Orangtua;
use Illuminate\Support\Facades\Hash;

echo "Memulai penetapan password seragam (ayah123 / ibu123)...\n";

$ortus = Orangtua::get();
$count = 0;

foreach ($ortus as $ortu) {
    $suffix = '123';
    $hubungan = strtolower($ortu->hubungan);
    
    if (strpos($hubungan, 'ayah') !== false) $newPassword = 'ayah123';
    elseif (strpos($hubungan, 'ibu') !== false) $newPassword = 'ibu123';
    else $newPassword = 'wali123';

    $ortu->update([
        'password' => Hash::make($newPassword)
    ]);

    echo "Update: {$ortu->hubungan} -> Password: {$newPassword}\n";
    $count++;
}

echo "\nSelesai! {$count} akun orang tua telah diseragamkan passwordnya.\n";
