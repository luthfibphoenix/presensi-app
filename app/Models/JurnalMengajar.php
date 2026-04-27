<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    protected $fillable = [
        'user_id',
        'qr_session_id',
        'tanggal',
        'mata_pelajaran',
        'kelas',
        'jam_mulai',
        'jam_selesai',
        'ringkasan_materi',
        'semester',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presensi()
    {
        return $this->hasMany(JurnalPresensi::class, 'jurnal_id');
    }

    public static function syncAttendance($jurnalId)
    {
        $jurnal = self::find($jurnalId);
        if (!$jurnal) return;

        $qrSession = QrSession::find($jurnal->qr_session_id);
        if (!$qrSession) return;

        // Sync real-time presensis
        $presensis = Presensi::with('siswa')
            ->where('jadwal_id', $qrSession->jadwal_id)
            ->where('tanggal', $jurnal->tanggal)
            ->get();

        // Clear and rebuild
        JurnalPresensi::where('jurnal_id', $jurnalId)->delete();

        foreach ($presensis as $p) {
            JurnalPresensi::create([
                'jurnal_id' => $jurnalId,
                'nama_siswa' => $p->siswa->nama,
                'status' => $p->status
            ]);
        }

        // Add missing students as 'Belum Absen'
        $kelas = Kelas::where('nama_kelas', $jurnal->kelas)->first();
        if ($kelas) {
            $allSiswaIds = Siswa::where('kelas_id', $kelas->id)->pluck('id')->toArray();
            $presentSiswaIds = $presensis->pluck('siswa_id')->toArray();
            $missingSiswaIds = array_diff($allSiswaIds, $presentSiswaIds);

            foreach ($missingSiswaIds as $siswaId) {
                $siswa = Siswa::find($siswaId);
                if ($siswa) {
                    JurnalPresensi::create([
                        'jurnal_id' => $jurnalId,
                        'nama_siswa' => $siswa->nama,
                        'status' => 'Belum Absen'
                    ]);
                }
            }
        }
    }
}
