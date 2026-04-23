<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Presensi;
use App\Models\Izin;
use Carbon\Carbon;

class OrtuDashboardController extends Controller
{
    public function index()
    {
        $ortu = Auth::guard('orangtua')->user();
        $siswa = $ortu->siswa;
        
        // Status Hari Ini
        $presensiHariIni = Presensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', Carbon::today())
            ->get();

        // Cek Kehadiran (Anggap jika ada record hadir/terlambat berarti masuk)
        $isHadir = $presensiHariIni->whereIn('status', ['Hadir', 'Terlambat'])->count() > 0;
        // Cek Alfa (Jika ada status Alfa)
        $isAlfa = $presensiHariIni->where('status', 'Alfa')->count() > 0;
        
        // Rekap Kehadiran Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $presensiBulanIni = Presensi::where('siswa_id', $siswa->id)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get();
            
        $rekap = [
            'hadir' => $presensiBulanIni->where('status', 'Hadir')->count(),
            'terlambat' => $presensiBulanIni->where('status', 'Terlambat')->count(),
            'alfa' => $presensiBulanIni->where('status', 'Alfa')->count(),
            'izin' => $presensiBulanIni->whereIn('status', ['Izin', 'Sakit'])->count(),
        ];

        return view('ortu.dashboard', compact('siswa', 'rekap', 'presensiHariIni', 'isHadir', 'isAlfa'));
    }

    public function kehadiran(Request $request)
    {
        $ortu = Auth::guard('orangtua')->user();
        $siswa = $ortu->siswa;
        
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $riwayat = Presensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->with('jadwal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('ortu.kehadiran', compact('riwayat', 'bulan', 'tahun', 'siswa'));
    }

    public function izin()
    {
        $ortu = Auth::guard('orangtua')->user();
        $siswa = $ortu->siswa;
        
        $izins = Izin::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('ortu.izin', compact('izins', 'siswa'));
    }

    public function profil()
    {
        $ortu = Auth::guard('orangtua')->user();
        $siswa = $ortu->siswa;
        
        return view('ortu.profil', compact('ortu', 'siswa'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:3|confirmed',
        ]);

        $user = Auth::guard('orangtua')->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }
}
