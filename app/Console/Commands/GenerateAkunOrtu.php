<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siswa;
use App\Models\Orangtua;
use Illuminate\Support\Facades\Hash;

class GenerateAkunOrtu extends Command
{
    protected $signature = 'generate:akun-ortu';
    protected $description = 'Generate atau update akun orang tua dengan format username (nama depan anak).NIS dan password ortu123';

    public function handle()
    {
        $siswas = Siswa::where(function($q) {
            $q->whereNotNull('nama_ayah')->orWhereNotNull('nama_ibu');
        })->get();

        $countCreated = 0;
        $countUpdated = 0;
        $passwordDefault = Hash::make('ortu123');

        $this->info("Memproses data orang tua untuk " . $siswas->count() . " siswa...");

        foreach ($siswas as $siswa) {
            $nis = $siswa->nis;
            if (empty($nis)) {
                $this->warn("Siswa {$siswa->nama} tidak memiliki NIS, melewati...");
                continue;
            }

            // Format Username: (nama depan anak).nis
            $namaDepan = strtolower(explode(' ', trim($siswa->nama))[0]);
            $username = "{$namaDepan}.{$nis}";

            // Prioritas nama Ibu, jika tidak ada baru Ayah
            $namaOrtu = $siswa->nama_ibu ?: $siswa->nama_ayah;
            $hubungan = $siswa->nama_ibu ? 'Ibu' : 'Ayah';

            $res = $this->upsertAccount($siswa, $namaOrtu, $hubungan, $username, $passwordDefault);
            if ($res === 'created') $countCreated++;
            elseif ($res === 'updated') $countUpdated++;
        }

        $this->info("\nSelesai!");
        $this->info("Akun Baru: {$countCreated}");
        $this->info("Akun Diupdate: {$countUpdated}");
    }

    private function upsertAccount($siswa, $nama, $hubungan, $username, $passwordHash)
    {
        // Cari akun yang sudah ada untuk siswa ini (apapun hubungannya)
        $account = Orangtua::where('siswa_id', $siswa->id)->first();

        if ($account) {
            // Bersihkan akun ganda jika ada (misal dulu ada Ayah & Ibu terpisah)
            Orangtua::where('siswa_id', $siswa->id)
                    ->where('id', '!=', $account->id)
                    ->delete();

            // Update username dan password sesuai format baru
            $account->update([
                'username' => $username,
                'password' => $passwordHash,
                'nama' => $nama,
                'hubungan' => $hubungan
            ]);
            $this->line("<fg=yellow>Updated:</> {$nama} -> <fg=cyan>{$username}</>");
            return 'updated';
        } else {
            // Buat baru
            Orangtua::create([
                'siswa_id' => $siswa->id,
                'nama' => $nama,
                'hubungan' => $hubungan,
                'username' => $username,
                'password' => $passwordHash,
            ]);
            $this->line("<fg=green>Created:</> {$nama} -> <fg=cyan>{$username}</>");
            return 'created';
        }
    }
}
