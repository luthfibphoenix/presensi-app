<?php

use App\Models\Orangtua;
use App\Models\Siswa;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Memulai pembersihan dan update username...\n";

// 1. Bersihkan Duplikat (Hanya sisakan satu akun per siswa_id)
$siswaIds = Orangtua::select('siswa_id')->groupBy('siswa_id')->havingRaw('COUNT(*) > 1')->pluck('siswa_id');

foreach ($siswaIds as $id) {
    $duplicates = Orangtua::where('siswa_id', $id)->orderBy('id', 'desc')->get();
    $keep = $duplicates->shift(); // Ambil satu untuk disimpan
    
    foreach ($duplicates as $dupe) {
        echo "Menghapus akun duplikat ID: {$dupe->id} untuk Siswa ID: {$id}\n";
        $dupe->delete();
    }
}

// 2. Update Username ke format Netral
$orangtuas = Orangtua::all();
foreach ($orangtuas as $o) {
    $siswa = $o->siswa;
    if ($siswa) {
        $namaDepan = strtolower(explode(' ', trim($siswa->nama))[0]);
        $newUsn = 'ortu.' . $namaDepan . '.' . $siswa->nis;
        
        try {
            $o->username = $newUsn;
            $o->save();
            echo "Updated Username: {$newUsn}\n";
        } catch (\Exception $e) {
            echo "Gagal update {$newUsn}: " . $e->getMessage() . "\n";
        }
    }
}

echo "Pembersihan selesai!\n";
