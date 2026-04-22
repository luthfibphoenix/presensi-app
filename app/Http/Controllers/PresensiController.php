<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\QrSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PresensiController extends Controller
{
    public function generate(Request $request)
    {
        // Example implementation for generating QR
        $jadwals = Jadwal::where('user_id', $request->user()->id)->get();
        return view('presensi.generate', compact('jadwals'));
    }

    public function storeQr(Request $request)
    {
        $jadwal_id = $request->jadwal_id;
        $token = Str::random(32);
        
        $qrSession = QrSession::create([
            'jadwal_id' => $jadwal_id,
            'tanggal' => now()->toDateString(),
            'token' => $token,
            'expired_at' => now()->addHours(2), // 2 hours validity
        ]);

        return redirect()->route('presensi.generate')->with('success', 'QR Code berhasil dibuat dengan token: ' . $token);
    }

    public function scan()
    {
        return view('presensi.scan');
    }

    public function processScan(Request $request)
    {
        $token = $request->token;
        $siswa = $request->user('siswa');
        
        $qrSession = QrSession::where('token', $token)
            ->where('tanggal', now()->toDateString())
            ->where('expired_at', '>=', now())
            ->first();

        if (!$qrSession) {
            return response()->json(['success' => false, 'message' => 'QR Code tidak valid atau sudah kadaluarsa.']);
        }

        // Catat presensi
        Presensi::create([
            'siswa_id'  => $siswa->id,
            'jadwal_id' => $qrSession->jadwal_id,
            'tanggal'   => now()->toDateString(),
            'status'    => 'Hadir',
        ]);

        return response()->json(['success' => true, 'message' => 'Berhasil absen!']);
    }

    public function riwayatSiswa(Request $request)
    {
        $siswa = $request->user('siswa');
        $riwayats = Presensi::where('siswa_id', $siswa->id)->with('jadwal')->paginate(10);
        return view('siswa.riwayat', compact('riwayats'));
    }
}
