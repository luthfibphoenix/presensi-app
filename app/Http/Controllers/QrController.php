<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\QrSession;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QrController extends Controller
{
    public static function getJamWaktu($jamKe)
    {
        return Jadwal::getWaktu($jamKe);
    }

    public function jadwalHariIni(Request $request)
    {
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $hariIni = ucfirst(strtolower($hariIni));

        $jadwals = Jadwal::where('user_id', $request->user()->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        $jamMap = Jadwal::jamMap();
        $nowTime = Carbon::now('Asia/Jakarta')->format('H:i');

        return view('guru.jadwal.index', compact('jadwals', 'jamMap', 'nowTime', 'hariIni'));
    }

    public function jadwalSemua(Request $request)
    {
        $jadwals = Jadwal::where('user_id', $request->user()->id)
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 ELSE 7 END")
            ->orderBy('jam_mulai')
            ->get();

        $hariIni = ucfirst(strtolower(Carbon::now()->locale('id')->isoFormat('dddd')));
        $jamMap = Jadwal::jamMap();
        $nowTime = Carbon::now('Asia/Jakarta')->format('H:i');

        return view('guru.jadwal.semua', compact('jadwals', 'jamMap', 'nowTime', 'hariIni'));
    }

    public function autoGenerate(Request $request)
    {
        $user = $request->user();
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $hariIni = ucfirst(strtolower($hariIni));
        $nowTime = Carbon::now()->format('H:i');

        // Cari jadwal yang sedang berlangsung saat ini
        $jadwals = Jadwal::where('user_id', $user->id)
            ->where('hari', $hariIni)
            ->get();

        $activeJadwal = null;

        foreach ($jadwals as $j) {
            $startTime = Jadwal::getWaktu($j->jam_mulai);
            $endTimeStart = Jadwal::getWaktu($j->jam_selesai);
            
            if ($startTime && $endTimeStart) {
                // Akhir jam pelajaran adalah waktu mulai jam terakhir + 45 menit
                $endDateTime = Carbon::createFromFormat('H:i', $endTimeStart, 'Asia/Jakarta')->addMinutes(45)->format('H:i');
                
                if ($nowTime >= $startTime && $nowTime <= $endDateTime) {
                    $activeJadwal = $j;
                    break;
                }
            }
        }

        if ($activeJadwal) {
            // Matikan sesi aktif sebelumnya untuk jadwal ini di hari yang sama jika ada
            QrSession::where('jadwal_id', $activeJadwal->id)
                ->where('tanggal', now()->toDateString())
                ->update(['expired_at' => Carbon::now()->subSecond()]);

            $token = Str::uuid()->toString();
            $qrSession = QrSession::create([
                'jadwal_id'  => $activeJadwal->id,
                'tanggal'    => now()->toDateString(),
                'token'      => $token,
                'expired_at' => Carbon::now()->addMinutes(15),
            ]);

            return redirect()->route('guru.mulai.kelas', $qrSession->id)
                ->with('success', 'Sesi presensi otomatis dimulai untuk: ' . $activeJadwal->mata_pelajaran . ' - ' . $activeJadwal->kelas);
        }

        // Jika tidak ada jadwal yang aktif saat ini, arahkan ke halaman pilih manual
        return redirect()->route('presensi.generate.view')
            ->with('warning', 'Tidak ditemukan jadwal aktif untuk jam sekarang (' . $nowTime . '). Silakan pilih jadwal secara manual.');
    }

    public function generateView(Request $request)
    {
        $jadwals = Jadwal::where('user_id', $request->user()->id)->get();
        return view('guru.qr.generate', compact('jadwals'));
    }

    public function generate(Request $request)
    {
        $request->validate(['jadwal_id' => 'required|exists:jadwals,id']);

        $jadwal = Jadwal::findOrFail($request->jadwal_id);

        QrSession::where('jadwal_id', $jadwal->id)
            ->where('tanggal', now()->toDateString())
            ->update(['expired_at' => Carbon::now()->subSecond()]);

        $token = Str::uuid()->toString();
        $qrSession = QrSession::create([
            'jadwal_id'  => $jadwal->id,
            'tanggal'    => now()->toDateString(),
            'token'      => $token,
            'expired_at' => Carbon::now()->addMinutes(15),
        ]);

        return redirect()->route('guru.mulai.kelas', $qrSession->id);
    }

    public function mulaiKelas(Request $request, $sessionId)
    {
        $qrSession = QrSession::with('jadwal')->findOrFail($sessionId);

        if ($qrSession->jadwal->user_id !== $request->user()->id) {
            abort(403);
        }

        $jadwal    = $qrSession->jadwal;
        $qrUrl     = config('app.url') . '/siswa/scan/' . $qrSession->token . '?ngrok-skip-browser-warning=true';
        $expiredAt = Carbon::parse($qrSession->expired_at);
        $jamMap    = Jadwal::jamMap();

        $startTimeStr = Jadwal::getWaktu($jadwal->jam_mulai);
        $endTimeStartStr = Jadwal::getWaktu($jadwal->jam_selesai);
        
        $startTime = Carbon::createFromFormat('H:i', $startTimeStr, 'Asia/Jakarta');
        $endTime = Carbon::createFromFormat('H:i', $endTimeStartStr, 'Asia/Jakarta')->addMinutes(45);
        $now = Carbon::now('Asia/Jakarta');

        // Status Waktu - QR tampil selama jam pelajaran berlangsung
        $isWithinSchedule = ($now->greaterThanOrEqualTo($startTime) && $now->lessThanOrEqualTo($endTime));
        $isPastSchedule   = ($now->greaterThan($endTime));

        $kelas      = Kelas::where('nama_kelas', $jadwal->kelas)->first();
        
        // Auto-sync Izin before displaying monitoring
        if ($kelas) {
            \App\Http\Controllers\IzinController::syncAllForClass($jadwal->kelas, now()->toDateString());
        }

        $totalSiswa = $kelas ? Siswa::where('kelas_id', $kelas->id)->count() : 0;

        // Fetch all students with their attendance status
        $allStudents = Siswa::where('kelas_id', $kelas->id)->orderBy('nama')->get();
        $presensis   = Presensi::where('jadwal_id', $jadwal->id)
            ->where('tanggal', now()->toDateString())
            ->get()
            ->keyBy('siswa_id');

        return view('guru.qr.mulai', compact(
            'qrSession', 'jadwal', 'qrUrl', 'expiredAt', 'jamMap', 'totalSiswa', 'allStudents', 'presensis',
            'isWithinSchedule', 'isPastSchedule'
        ));
    }

    public function refresh(Request $request, $sessionId)
    {
        $qrSession = QrSession::with('jadwal')->findOrFail($sessionId);

        if ($qrSession->jadwal->user_id !== $request->user()->id) {
            abort(403);
        }

        $newToken = Str::uuid()->toString();
        $qrSession->update([
            'token'      => $newToken,
            'expired_at' => Carbon::now()->addMinutes(15),
        ]);

        return redirect()->route('guru.mulai.kelas', $sessionId)
            ->with('success', 'QR Code berhasil diperbarui. Berlaku 15 menit lagi.');
    }

    public function end(Request $request, $sessionId)
    {
        $qrSession = QrSession::with('jadwal')->findOrFail($sessionId);

        if ($qrSession->jadwal->user_id !== $request->user()->id) {
            abort(403);
        }

        $qrSession->update(['expired_at' => Carbon::now()->subSecond()]);

        return redirect()->route('jadwal.hari.ini')
            ->with('success', 'Kelas telah diakhiri.');
    }

    public function statusJson(Request $request, $jadwalId)
    {
        $jadwal = Jadwal::findOrFail($jadwalId);
        $kelas  = Kelas::where('nama_kelas', $jadwal->kelas)->first();
        
        if (!$kelas) {
            return response()->json(['students' => [], 'hadir_count' => 0, 'total_count' => 0]);
        }

        // Auto-sync Izin before returning JSON status
        \App\Http\Controllers\IzinController::syncAllForClass($jadwal->kelas, now()->toDateString());

        $allStudents = Siswa::where('kelas_id', $kelas->id)->orderBy('nama')->get();
        $presensis   = Presensi::where('jadwal_id', $jadwal->id)
            ->where('tanggal', now()->toDateString())
            ->get()
            ->keyBy('siswa_id');

        $students = $allStudents->map(function($student) use ($presensis) {
            $p = $presensis->get($student->id);
            return [
                'nama' => $student->nama,
                'status' => $p ? $p->status : 'Belum Absen',
                'terlambat_menit' => $p ? $p->terlambat_menit : 0,
            ];
        });

        return response()->json([
            'students' => $students,
            'hadir_count' => $presensis->whereIn('status', ['Hadir', 'Terlambat'])->count(),
            'total_count' => $allStudents->count(),
        ]);
    }

    public function status(Request $request, $jadwalId)
    {
        $jadwal = Jadwal::findOrFail($jadwalId);
        $presensis = Presensi::with('siswa')
            ->where('jadwal_id', $jadwal->id)
            ->where('tanggal', now()->toDateString())
            ->get();
        return view('guru.qr.status', compact('jadwal', 'presensis'));
    }

    public function statusIndex(Request $request)
    {
        $user = $request->user();
        if (in_array($user->position, ['Administrator', 'Guru BK', 'Guru Piket'])) {
            $jadwals = Jadwal::all();
        } else {
            $jadwals = Jadwal::where('user_id', $user->id)->get();
        }
        return view('guru.qr.status_index', compact('jadwals'));
    }

    public function scanner()
    {
        return view('siswa.scan');
    }

    public function scan(Request $request, $token)
    {
        $siswa = $request->user('siswa');

        $qrSession = QrSession::where('token', $token)
            ->where('tanggal', now()->toDateString())
            ->first();

        if (!$qrSession) {
            return view('siswa.scan_result', [
                'status'  => 'error',
                'message' => 'QR Code tidak valid atau sudah tidak berlaku.',
            ]);
        }

        if (Carbon::now()->greaterThan($qrSession->expired_at)) {
            return view('siswa.scan_result', [
                'status'  => 'expired',
                'message' => 'QR Code sudah kadaluarsa. Minta guru untuk melakukan Refresh QR.',
            ]);
        }

        $kelasNama = optional($siswa->kelas)->nama_kelas ?? $siswa->nama_kelas ?? 'Unknown';

        // Validasi apakah siswa berada di kelas yang benar sesuai jadwal QR
        if ($qrSession->jadwal->kelas !== $kelasNama) {
            return view('siswa.scan_result', [
                'status'  => 'error',
                'message' => 'Maaf, QR Code ini ditujukan untuk kelas ' . $qrSession->jadwal->kelas . '. Anda berada di kelas ' . $kelasNama . '.',
            ]);
        }

        $jadwal = $qrSession->jadwal;
        $startTimeStr = Jadwal::getWaktu($jadwal->jam_mulai);
        $startTime = Carbon::createFromFormat('H:i', $startTimeStr, 'Asia/Jakarta');
        $now = Carbon::now('Asia/Jakarta');

        $diffInMinutes = $startTime->diffInMinutes($now, false);
        $status = 'Hadir';
        $terlambatMenit = 0;

        if ($diffInMinutes > 15) {
            $status = 'Terlambat';
            $terlambatMenit = floor($diffInMinutes);
        }

        $sudahAbsen = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', now()->toDateString())
            ->where('jadwal_id', $jadwal->id)
            ->exists();

        if ($sudahAbsen) {
            return view('siswa.scan_result', [
                'status'  => 'info',
                'message' => 'Kamu sudah melakukan absen hari ini! ✅',
            ]);
        }

        Presensi::create([
            'jadwal_id' => $jadwal->id,
            'siswa_id'  => $siswa->id,
            'tanggal'    => now()->toDateString(),
            'status'     => $status,
            'terlambat_menit' => $terlambatMenit,
        ]);

        return view('siswa.scan_result', [
            'status'  => 'success',
            'message' => $status === 'Terlambat' 
                ? "Absen berhasil! Kamu terlambat {$terlambatMenit} menit. ⚠️" 
                : 'Absen berhasil! Kehadiran kamu telah dicatat. ✅',
            'nama'    => $siswa->nama,
            'kelas'   => $kelasNama,
        ]);
    }
}