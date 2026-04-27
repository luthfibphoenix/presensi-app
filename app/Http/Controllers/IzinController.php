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

    public function indexOrangtua(Request $request)
    {
        $orangtua = auth('orangtua')->user();
        if (!$orangtua) return redirect()->route('login');
        
        $siswaIds = \App\Models\Siswa::where('no_hp_ortu', $orangtua->username)
                    ->orWhere('username_ortu', $orangtua->username)
                    ->pluck('id');
                    
        $izins = Izin::with('siswa')->whereIn('siswa_id', $siswaIds)->orderBy('tanggal', 'desc')->paginate(10);
        $siswas = \App\Models\Siswa::whereIn('id', $siswaIds)->get();
        
        return view('izin.index_ortu', compact('izins', 'siswas'));
    }

    public function storeOrangtua(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'alasan' => 'required|string',
            'tipe' => 'required|string|in:Izin,Sakit',
        ]);

        $orangtua = auth('orangtua')->user();
        // Pastikan siswa yang dipilih adalah anak dari ortu ini
        $isChild = \App\Models\Siswa::where('id', $request->siswa_id)
                    ->where(function($q) use ($orangtua) {
                        $q->where('no_hp_ortu', $orangtua->username)
                          ->orWhere('username_ortu', $orangtua->username);
                    })->exists();

        if (!$isChild) {
            return redirect()->back()->with('error', 'Siswa tidak valid.');
        }

        Izin::create([
            'siswa_id' => $request->siswa_id,
            'tanggal'  => $request->tanggal,
            'alasan'   => $request->alasan . ' (Input oleh Ortu)',
            'status'   => 'pending',
            'tipe'     => $request->tipe,
        ]);

        return redirect()->back()->with('success', 'Permohonan izin berhasil dikirim. Menunggu verifikasi Guru Piket.');
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
            'tipe' => 'required|string|in:Izin,Sakit,Masuk Telat,Keluar Sekolah',
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

        $loginRole = session('login_role', 'umum');

        if ($loginRole === 'piket') {
            // Guru Piket sekarang bisa melihat semua tipe izin untuk memantau kehadiran siswa secara penuh
            // $query->whereIn('tipe', ['Masuk Telat', 'Keluar Sekolah']); // Baris ini dihapus agar semua muncul
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

    public static function syncPresensi(Izin $izin)
    {
        $siswa = $izin->siswa;
        $tanggal = $izin->tanggal;
        $dayName = \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd');
        $dayName = ucfirst(strtolower($dayName));

        // Tentukan status presensi berdasarkan tipe izin
        $statusPresensi = match($izin->tipe) {
            'Sakit' => 'Sakit',
            'Masuk Telat' => 'Terlambat',
            'Keluar Sekolah' => 'Izin',
            default => 'Izin'
        };

        // Jika alasan mengandung kata sakit, paksa jadi Sakit
        if (str_contains(strtolower($izin->alasan), 'sakit')) {
            $statusPresensi = 'Sakit';
        }

        // Ambil semua jadwal untuk kelas siswa di hari tersebut
        $jadwals = \App\Models\Jadwal::where('kelas', $siswa->kelas->nama_kelas ?? '')
            ->where('hari', $dayName)
            ->get();

        foreach ($jadwals as $jadwal) {
            \App\Models\Presensi::updateOrCreate(
                [
                    'siswa_id'  => $siswa->id,
                    'jadwal_id' => $jadwal->id,
                    'tanggal'   => $tanggal,
                ],
                [
                    'status'    => $statusPresensi,
                    'keterangan' => 'Auto-sync: ' . $izin->alasan
                ]
            );
        }
    }

    public static function syncAllForClass($kelasNama, $tanggal)
    {
        $izins = Izin::where('tanggal', $tanggal)->where('status', 'approve')->get();
        foreach ($izins as $izin) {
            if ($izin->siswa && $izin->siswa->kelas && $izin->siswa->kelas->nama_kelas === $kelasNama) {
                self::syncPresensi($izin);
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
        $kepala = \App\Models\User::where('position', 'like', '%Kepala Sekolah%')->first();
        return view('izin.print', compact('izin', 'kepala'));
    }
}
