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
            'tipe' => 'nullable|string|in:Izin,Sakit,Masuk Telat,Keluar Sekolah',
        ]);

        $siswa = auth('siswa')->user();

        if (!$siswa) {
            return redirect()->route('siswa.login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        Izin::create([
            'siswa_id' => $siswa->id,
            'tanggal'  => $request->tanggal,
            'alasan'   => $request->alasan,
            'status'   => 'pending',
            'tipe'     => $request->tipe ?? 'Izin',
        ]);

        return redirect()->back()->with('success', 'Izin berhasil diajukan.');
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'alasan' => 'required|string',
            'tipe' => 'required|string|in:Masuk Telat,Keluar Sekolah',
        ]);

        $izin = Izin::create([
            'siswa_id' => $request->siswa_id,
            'tanggal'  => $request->tanggal,
            'alasan'   => $request->alasan,
            'status'   => 'approve',
            'tipe'     => $request->tipe,
            'petugas_piket' => auth('web')->user()->fullname ?? 'Petugas Piket',
            'approved_by' => auth('web')->id(),
        ]);

        $this->syncPresensi($izin);

        return redirect()->back()->with('success', 'Data izin/keterangan berhasil disimpan.');
    }

    public function indexGuru(Request $request)
    {
        $user = $request->user();
        $query = Izin::with('siswa.kelas');

        if (strpos($user->position, 'Piket') !== false && !in_array($user->position, ['Administrator', 'Guru BK'])) {
            $query->whereIn('tipe', ['Masuk Telat', 'Keluar Sekolah']);
        }

        $izins = $query->orderBy('tanggal', 'desc')->paginate(10);
        $siswas = \App\Models\Siswa::with('kelas')->orderBy('nama')->get();
        $kelases = \App\Models\Kelas::orderBy('nama_kelas')->get();

        return view('izin.index_guru', compact('izins', 'siswas', 'kelases'));
    }

    public function approve(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update([
            'status' => 'approve',
            'petugas_piket' => auth('web')->user()->fullname ?? 'Petugas Piket',
            'approved_by' => auth('web')->id(),
        ]);
        
        $this->syncPresensi($izin);

        return redirect()->back()->with('success', 'Izin berhasil disetujui dan data presensi telah diperbarui.');
    }

    private function syncPresensi(Izin $izin)
    {
        $siswa = $izin->siswa;
        $tanggal = $izin->tanggal;
        $dayName = \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd');
        $dayName = ucfirst(strtolower($dayName));

        // Tentukan status presensi
        $statusPresensi = 'Izin';
        if (str_contains(strtolower($izin->alasan), 'sakit') || $izin->tipe === 'Sakit') {
            $statusPresensi = 'Sakit';
        } elseif ($izin->tipe === 'Masuk Telat') {
            $statusPresensi = 'Terlambat';
        } elseif ($izin->tipe === 'Keluar Sekolah') {
            $statusPresensi = 'Keluar';
        }

        // Ambil semua jadwal untuk kelas siswa di hari tersebut
        $jadwals = \App\Models\Jadwal::where('kelas', $siswa->kelas->nama_kelas ?? '')
            ->where('hari', $dayName)
            ->get();

        foreach ($jadwals as $jadwal) {
            $exists = \App\Models\Presensi::where('nama_siswa', $siswa->nama)
                ->where('kelas', $jadwal->kelas)
                ->where('tanggal', $tanggal)
                ->first();

            if ($exists) {
                $exists->update(['status' => $statusPresensi]);
            } else {
                \App\Models\Presensi::create([
                    'nama_siswa' => $siswa->nama,
                    'kelas'      => $jadwal->kelas,
                    'tanggal'    => $tanggal,
                    'status'     => $statusPresensi,
                ]);
            }
        }
    }

    public function reject(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => 'reject']);

        return redirect()->back()->with('success', 'Izin ditolak.');
    }
    public function print($id)
    {
        $izin = Izin::with(['siswa.kelas', 'approvedBy'])->findOrFail($id);
        return view('izin.print', compact('izin'));
    }
}
