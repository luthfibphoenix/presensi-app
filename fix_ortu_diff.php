<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Orangtua;
use Illuminate\Support\Facades\Hash;

echo "Mereset password: Ayah -> ayah123, Ibu -> ibu123...\n";

$ortus = Orangtua::get();
$count = 0;

foreach ($ortus as $ortu) {
    $hubungan = strtolower($ortu->hubungan);
    if (strpos($hubungan, 'ayah') !== false) $newPass = 'ayah123';
    elseif (strpos($hubungan, 'ibu') !== false) $newPass = 'ibu123';
    else $newPass = 'ortu123';

    $ortu->password = Hash::make($newPass);
    $ortu->save();

    echo "Update: {$ortu->hubungan} -> PW: {$newPass}\n";
    $count++;
}

echo "\nSelesai! {$count} akun diperbarui.\n";
