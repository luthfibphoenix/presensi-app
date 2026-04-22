<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $pos = strtolower($user->position ?? '');
        $loginRole = session('login_role', 'umum');

        // Cek apakah ada sesi QR aktif untuk guru ini hari ini
        $activeSession = null;
        if ($user) {
            $activeSession = \App\Models\QrSession::with('jadwal')
                ->where('guru_id', $user->id)
                ->where('tanggal', now()->toDateString())
                ->where('expired_at', '>', now())
                ->first();
        }

        // Prioritas berdasarkan session login_role
        if ($loginRole === 'admin') {
            return view('dashboard.admin');
        }

        if ($loginRole === 'piket') {
            return view('dashboard.gurupiket');
        }

        if ($loginRole === 'bk') {
            return view('dashboard.gurubk');
        }

        if ($loginRole === 'guru') {
            return view('dashboard.guru', compact('activeSession'));
        }

        // Fallback berdasarkan position
        if (str_contains($pos, 'administrator')) return view('dashboard.admin');
        if (str_contains($pos, 'kepala sekolah')) return view('dashboard.admin');
        if (str_contains($pos, 'bk')) return view('dashboard.gurubk');
        if (str_contains($pos, 'guru') || str_contains($pos, 'waka') || str_contains($pos, 'kakonli') || str_contains($pos, 'tata usaha')) return view('dashboard.guru', compact('activeSession'));
        if ($user->is_wali) return view('dashboard.walikelas');
        if (str_contains($pos, 'piket')) return view('dashboard.gurupiket');

        return view('dashboard.guru', compact('activeSession'));
    }

    public function endSession(Request $request)
    {
        $request->validate(['session_id' => 'required|exists:qr_sessions,id']);
        $session = \App\Models\QrSession::with('jadwal')->findOrFail($request->session_id);

        if ($session->guru_id !== auth()->id()) {
            abort(403);
        }

        // 1. Akhiri sesi (set expired)
        $session->update(['expired_at' => now()->subSecond()]);

        // 2. Tandai siswa yang belum absen sebagai Alfa
        $jadwal = $session->jadwal;
        $kelas = \App\Models\Kelas::where('nama_kelas', $jadwal->kelas)->first();
        
        if ($kelas) {
            $students = \App\Models\Siswa::where('kelas_id', $kelas->id)->get();
            $today = now()->toDateString();
            
            foreach ($students as $student) {
                $exists = \App\Models\Presensi::where('siswa_id', $student->id)
                    ->where('tanggal', $today)
                    ->where('jadwal_id', $jadwal->id)
                    ->exists();
                
                if (!$exists) {
                    // Cek apakah ada izin/sakit yang sudah disetujui
                    $izin = \App\Models\Izin::where('siswa_id', $student->id)
                        ->where('tanggal', $today)
                        ->where('status', 'Disetujui') // Sesuaikan dengan status di database
                        ->first();
                    
                    $status = 'Alfa';
                    $keterangan = null;
                    
                    if ($izin) {
                        $status = ($izin->tipe === 'Sakit') ? 'Sakit' : 'Izin';
                        $keterangan = $izin->alasan;
                    }

                    \App\Models\Presensi::create([
                        'jadwal_id' => $jadwal->id,
                        'siswa_id'  => $student->id,
                        'tanggal'    => $today,
                        'status'     => $status,
                        'keterangan' => $keterangan,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Kelas berhasil diakhiri. Siswa yang tidak hadir telah dicatat Alfa.');
    }

    public function siswaDashboard(Request $request)
    {
        return view('siswa.dashboard');
    }

    public function generateQR(Request $request)
    {
        $user = auth()->user();
        $hariMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariIni = $hariMap[now()->format('l')];
        $nowTime = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');

        $jadwals = \App\Models\Jadwal::where('user_id', $user->id)
            ->where('hari', $hariIni)
            ->get();

        $activeJadwals = [];
        foreach ($jadwals as $j) {
            $start = \App\Models\Jadwal::getWaktu($j->jam_mulai);
            $endStart = \App\Models\Jadwal::getWaktu($j->jam_selesai);
            if ($start && $endStart) {
                $end = \Carbon\Carbon::createFromFormat('H:i', $endStart, 'Asia/Jakarta')->addMinutes(45)->format('H:i');
                if ($nowTime >= $start && $nowTime <= $end) {
                    $activeJadwals[] = $j;
                }
            }
        }

        if (count($activeJadwals) > 1 && !$request->jadwal_id) {
            return response()->json([
                'status' => 'multiple',
                'jadwals' => $activeJadwals
            ]);
        }

        $jadwal = null;
        if ($request->jadwal_id) {
            $jadwal = \App\Models\Jadwal::where('user_id', $user->id)->find($request->jadwal_id);
        } elseif (count($activeJadwals) === 1) {
            $jadwal = $activeJadwals[0];
        }

        if (!$jadwal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ditemukan jadwal aktif untuk jam sekarang (' . $nowTime . ').'
            ]);
        }

        \App\Models\QrSession::where('jadwal_id', $jadwal->id)
            ->where('tanggal', now()->toDateString())
            ->update(['expired_at' => now()->subSecond()]);

        $token = (string) \Illuminate\Support\Str::uuid();
        $expiredAt = now()->addMinutes(15);

        \App\Models\QrSession::create([
            'jadwal_id' => $jadwal->id,
            'guru_id' => $user->id,
            'tanggal' => now()->toDateString(),
            'token' => $token,
            'expired_at' => $expiredAt,
        ]);

        $qrUrl = url('/siswa/scan/' . $token);
        $qrCode = (string) \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(300)->margin(1)->generate($qrUrl);

        return response()->json([
            'status' => 'success',
            'qr_code' => $qrCode,
            'token' => $token,
            'mapel' => $jadwal->mata_pelajaran,
            'kelas' => $jadwal->kelas,
            'hari'  => $jadwal->hari,
            'jam' => jamPelajaranToWaktu($jadwal->jam_mulai) . ' - ' . \Carbon\Carbon::createFromFormat('H:i', jamPelajaranToWaktu($jadwal->jam_selesai), 'Asia/Jakarta')->addMinutes(45)->format('H:i'),
            'expired_at' => $expiredAt->toDateTimeString()
        ]);
    }
}