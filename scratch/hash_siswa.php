<?php
// Hash semua password siswa yang masih plain text
App\Models\Siswa::all()->each(function ($s) {
    if (strlen($s->password) < 60) { // belum di-hash
        $s->updateQuietly(['password' => bcrypt($s->password)]);
        echo "Hashed: {$s->username}\n";
    }
});
echo "Selesai!\n";
