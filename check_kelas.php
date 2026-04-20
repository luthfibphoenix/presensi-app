<?php
// Cek kelas sekarang punya id
$kelas = DB::table('kelas')->get();
echo "Kelas:\n";
foreach ($kelas as $k) {
    echo "  id={$k->id} | {$k->nama_kelas} ({$k->kode_kelas})\n";
}

// Cek siswas
echo "\nSiswas kelas_id:\n";
$siswas = DB::table('siswas')->get();
foreach ($siswas as $s) {
    echo "  {$s->nama} → kelas_id={$s->kelas_id}\n";
}

// Test relasi
echo "\nTest relasi Siswa->kelas:\n";
$siswa = App\Models\Siswa::with('kelas')->first();
echo "  Siswa: {$siswa->nama}\n";
echo "  Kelas: " . ($siswa->kelas ? $siswa->kelas->nama_kelas : 'NULL') . "\n";
