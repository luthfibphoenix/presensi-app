<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Izin;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Presensi::with(['siswa', 'jadwal']);
        
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }
        
        if ($request->filled('kelas_id')) {
            $kelasId = $request->kelas_id;
            $query->whereHas('siswa', function($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        $presensis = $query->orderBy('tanggal', 'desc')->paginate(20);
        $kelases = Kelas::all();
        
        return view('laporan.index', compact('presensis', 'kelases'));
    }

    public function rekapHarian(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->toDateString());
        $kelasId = $request->get('kelas_id');
        
        $dayMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hari = $dayMap[Carbon::parse($tanggal)->format('l')];

        $kelases = Kelas::orderBy('nama_kelas')->get();
        $siswas = [];
        $totalSchedules = 0;

        if ($kelasId) {
            $kelas = Kelas::findOrFail($kelasId);
            $siswas = Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();
            
            // Get all schedules for this class today
            $jadwals = Jadwal::where('kelas', $kelas->nama_kelas)
                ->where('hari', $hari)
                ->get();
            
            $totalSchedules = $jadwals->count();
            $jadwalIds = $jadwals->pluck('id');

            foreach ($siswas as $siswa) {
                // Get attendance for these schedules
                $attendance = Presensi::where('siswa_id', $siswa->id)
                    ->where('tanggal', $tanggal)
                    ->whereIn('jadwal_id', $jadwalIds)
                    ->get();

                // Get approved permission for this day
                $izin = Izin::where('siswa_id', $siswa->id)
                    ->where('tanggal', $tanggal)
                    ->where('status', 'Disetujui')
                    ->first();

                $presentCount = $attendance->whereIn('status', ['Hadir', 'Terlambat'])->count();
                
                // Determine Final Status
                if ($izin) {
                    $siswa->status_akhir = $izin->tipe; // Sakit / Izin / Dispensasi
                    $siswa->keterangan = $izin->alasan;
                } elseif ($totalSchedules == 0) {
                    $siswa->status_akhir = 'Tidak ada Jadwal';
                    $siswa->keterangan = '-';
                } elseif ($presentCount == $totalSchedules) {
                    $siswa->status_akhir = 'Hadir Penuh';
                    $siswa->keterangan = "$presentCount/$totalSchedules Jam";
                } elseif ($presentCount > 0) {
                    $siswa->status_akhir = 'Hadir Sebagian';
                    $siswa->keterangan = "$presentCount/$totalSchedules Jam";
                } else {
                    $siswa->status_akhir = 'Alfa';
                    $siswa->keterangan = 'Tanpa Keterangan';
                }

                $siswa->present_count = $presentCount;
            }
        }

        return view('laporan.rekap_harian', compact('siswas', 'kelases', 'tanggal', 'kelasId', 'totalSchedules'));
    }
}
