<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function indexSiswa(Request $request)
    {
        $siswa = $request->user('siswa');
        $izins = Izin::where('siswa_id', $siswa->id)->orderBy('tanggal', 'desc')->paginate(10);
        return view('izin.index', compact('izins'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'alasan' => 'required|string',
        ]);

        $siswa = $request->user('siswa');

        Izin::create([
            'siswa_id' => $siswa->id,
            'tanggal'  => $request->tanggal,
            'alasan'   => $request->alasan,
            'status'   => 'pending',   // constraint: pending | approve | reject
        ]);

        return redirect()->back()->with('success', 'Izin berhasil diajukan.');
    }

    public function indexGuru(Request $request)
    {
        $izins = Izin::with('siswa.kelas')->orderBy('tanggal', 'desc')->paginate(10);
        return view('izin.index_guru', compact('izins'));
    }

    public function approve(Request $request, $id)
    {
        $izin = Izin::with('siswa.kelas')->findOrFail($id);
        $izin->update(['status' => 'approve']);

        $siswa = $izin->siswa;
        $tanggal = $izin->tanggal;
        $dayName = \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd');
        $dayName = ucfirst(strtolower($dayName));

        // Tentukan status presensi (Izin atau Sakit)
        $statusPresensi = (str_contains(strtolower($izin->alasan), 'sakit')) ? 'Sakit' : 'Izin';

        // Ambil semua jadwal untuk kelas siswa di hari tersebut
        $jadwals = \App\Models\Jadwal::where('kelas', $siswa->kelas->nama_kelas ?? '')
            ->where('hari', $dayName)
            ->get();

        foreach ($jadwals as $jadwal) {
            // Cek apakah sudah ada presensi untuk siswa ini di jadwal/hari ini
            $exists = \App\Models\Presensi::where('nama_siswa', $siswa->nama)
                ->where('kelas', $jadwal->kelas)
                ->where('tanggal', $tanggal)
                ->exists();

            if (!$exists) {
                \App\Models\Presensi::create([
                    'nama_siswa' => $siswa->nama,
                    'kelas'      => $jadwal->kelas,
                    'tanggal'    => $tanggal,
                    'status'     => $statusPresensi,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Izin berhasil disetujui dan data presensi telah diperbarui.');
    }

    public function reject(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => 'reject']);

        return redirect()->back()->with('success', 'Izin ditolak.');
    }
}
