<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;

class ImportSiswa extends Command
{
    protected $signature = 'import:siswa';
    protected $description = 'Import data siswa dari storage/app/siswa.csv';

    public function handle()
    {
        $filePath = storage_path('app/siswa.csv');
        
        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan di: " . $filePath);
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // Skip header

        $count = 0;
        $updated = 0;
        $skipped = 0;

        while (($data = fgetcsv($file)) !== FALSE) {
            $count++;
            $nama = $data[0];
            $namaKelas = $data[1];
            $tahunLulus = $data[2];
            $jk = $data[3];
            $nis = $data[4];
            $nisn = $data[5];
            $tempatLahir = $data[6];
            $tglLahir = $data[7];
            $nik = $data[8];
            $agama = $data[9];
            $alamat = $data[10];
            $ayah = $data[11];
            $ibu = $data[12];

            // Hanya import siswa yang kolom Kelasnya tidak kosong
            if (empty($namaKelas)) {
                $skipped++;
                continue;
            }

            // Cari kelas
            $kelas = Kelas::where('nama_kelas', $namaKelas)->first();
            if (!$kelas) {
                $this->warn("Kelas tidak ditemukan: {$namaKelas} untuk siswa {$nama}");
                $skipped++;
                continue;
            }

            // Cari siswa berdasarkan nama dan kelas_id
            $siswa = Siswa::where('nama', $nama)
                          ->where('kelas_id', $kelas->id)
                          ->first();

            if ($siswa) {
                $siswa->update([
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'jk' => $jk,
                    'tempat_lahir' => $tempatLahir,
                    'tgl_lahir' => !empty($tglLahir) ? $tglLahir : null,
                    'nik' => $nik,
                    'agama' => $agama,
                    'alamat' => $alamat,
                    'nama_ayah' => $ayah,
                    'nama_ibu' => $ibu,
                ]);
                $updated++;
            } else {
                $this->warn("Siswa tidak ditemukan di database: {$nama} ({$namaKelas})");
                $skipped++;
            }
        }

        fclose($file);

        $this->info("Import selesai!");
        $this->info("Total data di CSV: {$count}");
        $this->info("Berhasil update: {$updated}");
        $this->info("Diskip/Gagal: {$skipped}");
    }
}
