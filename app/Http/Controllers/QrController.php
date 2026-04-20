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
    protected static $jamMap = [
        1  => '07:00', 2  => '07:45', 3  => '08:30', 4  => '09:15',
        5  => '10:15', 6  => '11:00', 7  => '11:45', 8  => '12:30',
        9  => '13:15', 10 => '14:00', 11 => '14:45', 12 => '15:30',
    ];

    public static function getJamWaktu($jamKe)
    {
        return self::$jamMap[$jamKe] ?? sprintf('%02d:00', 6 + $jamKe);
    }

    public function jadwalHariIni(Request $request)
    {
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $hariIni = ucfirst(strtolower($hariIni));

        $jadwals = Jadwal::where('user_id', $request->user()->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        $jamMap = self::$jamMap;
        $nowTime = Carbon::now()->format('H:i');

        return view('guru.jadwal.index', compact('jadwals', 'jamMap', 'nowTime', 'hariIni'));
    }

    public function jadwalSemua(Request $request)
    {
        $jadwals = Jadwal::where('user_id', $request->user()->id)
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 ELSE 7 END")
            ->orderBy('jam_mulai')
            ->get();

        $hariIni = ucfirst(strtolower(Carbon::now()->locale('id')->isoFormat('dddd')));
        $jamMap = self::$jamMap;
        $nowTime = Carbon::now()->format('H:i');

        return view('guru.jadwal.semua', compact('jadwals', 'jamMap', 'nowTime', 'hariIni'));
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
            ->where('tanggal', date('Y-m-d'))
            ->update(['expired_at' => Carbon::now()->subSecond()]);

        $token = Str::uuid()->toString();
        $qrSession = QrSession::create([
            'jadwal_id'  => $jadwal->id,
            'tanggal'    => date('Y-m-d'),
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
        $qrUrl     = $request->getSchemeAndHttpHost() . '/siswa/scan/' . $qrSession->token;
        $expiredAt = Carbon::parse($qrSession->expired_at);
        $jamMap    = self::$jamMap;

        $kelas      = Kelas::where('nama_kelas', $jadwal->kelas)->first();
        $totalSiswa = $kelas ? Siswa::where('kelas_id', $kelas->id)->count() : 0;

        $presensis = Presensi::where('kelas', $jadwal->kelas)
            ->where('tanggal', date('Y-m-d'))
            ->orderByDesc('id')
            ->get();

        return view('guru.qr.mulai', compact(
            'qrSession', 'jadwal', 'qrUrl', 'expiredAt', 'jamMap', 'totalSiswa', 'presensis'
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

        $presensis = Presensi::where('kelas', $jadwal->kelas)
            ->where('tanggal', date('Y-m-d'))
            ->orderByDesc('id')
            ->get(['nama_siswa', 'status', 'tanggal']);

        $kelas      = Kelas::where('nama_kelas', $jadwal->kelas)->first();
        $totalSiswa = $kelas ? Siswa::where('kelas_id', $kelas->id)->count() : 0;

        return response()->json([
            'presensis'   => $presensis,
            'hadir'       => $presensis->count(),
            'total_siswa' => $totalSiswa,
        ]);
    }

    public function status(Request $request, $jadwalId)
    {
        $jadwal = Jadwal::findOrFail($jadwalId);
        $presensis = Presensi::where('kelas', $jadwal->kelas)
            ->where('tanggal', date('Y-m-d'))
            ->get();
        return view('guru.qr.status', compact('jadwal', 'presensis'));
    }

    public function statusIndex(Request $request)
    {
        $jadwals = Jadwal::where('user_id', $request->user()->id)->get();
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
            ->where('tanggal', date('Y-m-d'))
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

        $sudahAbsen = Presensi::where('nama_siswa', $siswa->nama)
            ->where('tanggal', date('Y-m-d'))
            ->where('kelas', $kelasNama)
            ->exists();

        if ($sudahAbsen) {
            return view('siswa.scan_result', [
                'status'  => 'info',
                'message' => 'Kamu sudah melakukan absen hari ini! ✅',
            ]);
        }

        Presensi::create([
            'nama_siswa' => $siswa->nama,
            'kelas'      => $kelasNama,
            'tanggal'    => date('Y-m-d'),
            'status'     => 'Hadir',
        ]);

        return view('siswa.scan_result', [
            'status'  => 'success',
            'message' => 'Absen berhasil! Kehadiran kamu telah dicatat. ✅',
            'nama'    => $siswa->nama,
            'kelas'   => $kelasNama,
        ]);
    }
}