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
            $today = now()->toDateString();
            
            // Statistik Hari Ini (Izin & Sakit diambil dari tabel Izin agar real-time dan unik per siswa)
            $stats = [
                'hadir' => \App\Models\Presensi::where('tanggal', $today)->whereIn('status', ['Hadir', 'Terlambat'])->distinct()->count('siswa_id'),
                'izin' => \App\Models\Izin::where('tanggal', $today)->where('tipe', 'Izin')->where('status', 'Disetujui')->count(),
                'sakit' => \App\Models\Izin::where('tanggal', $today)->where('tipe', 'Sakit')->where('status', 'Disetujui')->count(),
                'alfa' => \App\Models\Presensi::where('tanggal', $today)->where('status', 'Alfa')->distinct()->count('siswa_id'),
            ];

            // Siswa Tidak Hadir Hari Ini (Ambil dari Izin yang disetujui + Alfa di presensi)
            $todayPermits = \App\Models\Izin::with('siswa.kelas')
                ->where('tanggal', $today)
                ->where('status', 'Disetujui')
                ->get()
                ->filter(function($i) { return $i->siswa != null; })
                ->map(function($i) {
                    return (object)[
                        'siswa' => $i->siswa,
                        'status' => $i->tipe,
                        'keterangan' => $i->alasan,
                        'created_at' => $i->tanggal,
                        'jadwal' => (object)[
                            'mata_pelajaran' => 'Izin Harian',
                            'jam_mulai' => '-',
                            'jam_selesai' => '-'
                        ]
                    ];
                });

            $alfaPresensi = \App\Models\Presensi::with(['siswa.kelas', 'jadwal'])
                ->where('tanggal', $today)
                ->where('status', 'Alfa')
                ->get()
                ->filter(function($p) { return $p->siswa != null; });

            $absentStudents = $todayPermits->concat($alfaPresensi)->sortByDesc('created_at')->take(10);

            // Fetch Recent Activities for Guru Piket Feed
            $recentIzins = \App\Models\Izin::with('siswa.kelas')
                ->latest('id')
                ->take(5)
                ->get()
                ->map(function($i) {
                    $time = $i->created_at ? $i->created_at->diffForHumans() : 'Baru saja';
                    $kelasName = $i->siswa && $i->siswa->kelas ? $i->siswa->kelas->nama_kelas : 'Kelas';
                    $siswaName = $i->siswa ? $i->siswa->nama : 'Siswa';
                    return [
                        'type' => 'izin',
                        'title' => "Surat izin baru dari kelas " . $kelasName,
                        'desc' => $siswaName . " mengajukan izin: " . $i->alasan,
                        'time' => $time,
                        'icon' => 'fa-file-lines',
                        'color' => 'bg-amber-100 text-amber-600 border-amber-200',
                        'timestamp' => $i->created_at ? $i->created_at->timestamp : 0
                    ];
                });

            $recentPresensis = \App\Models\Presensi::with(['siswa.kelas', 'jadwal'])
                ->whereIn('status', ['Alfa', 'Terlambat', 'Sakit', 'Izin'])
                ->latest('id')
                ->take(5)
                ->get()
                ->map(function($p) {
                    $time = $p->created_at ? $p->created_at->diffForHumans() : 'Baru saja';
                    $siswaName = $p->siswa ? $p->siswa->nama : 'Siswa';
                    $status = strtolower($p->status);
                    $jp = $p->jadwal ? " Jam ke-" . $p->jadwal->jam_mulai : "";
                    
                    $icon = 'fa-clock';
                    $color = 'bg-blue-100 text-blue-600 border-blue-200';
                    if ($status === 'alfa') {
                        $icon = 'fa-user-xmark';
                        $color = 'bg-rose-100 text-rose-600 border-rose-200';
                    } elseif ($status === 'sakit') {
                        $icon = 'fa-hand-holding-medical';
                        $color = 'bg-cyan-100 text-cyan-600 border-cyan-200';
                    }

                    return [
                        'type' => 'presensi',
                        'title' => $siswaName . " tercatat " . $status . $jp,
                        'desc' => "Mata pelajaran: " . ($p->jadwal->mata_pelajaran ?? '-'),
                        'time' => $time,
                        'icon' => $icon,
                        'color' => $color,
                        'timestamp' => $p->created_at ? $p->created_at->timestamp : 0
                    ];
                });

            $activities = $recentIzins->concat($recentPresensis)->sortByDesc('timestamp')->values();

            // Fallback for visual completeness if db is empty
            if ($activities->count() < 3) {
                $mockActivities = collect([
                    [
                        'type' => 'izin',
                        'title' => 'Surat izin baru dari kelas XI RPL 2',
                        'desc' => 'Siswa mengajukan surat izin sakit secara digital.',
                        'time' => '5 menit lalu',
                        'icon' => 'fa-file-lines',
                        'color' => 'bg-amber-100 text-amber-600 border-amber-200'
                    ],
                    [
                        'type' => 'presensi',
                        'title' => 'Ahmad Fauzi tercatat alfa Jam ke-3',
                        'desc' => 'Belum melakukan scan QR hingga batas waktu berakhir.',
                        'time' => '22 menit lalu',
                        'icon' => 'fa-user-xmark',
                        'color' => 'bg-rose-100 text-rose-600 border-rose-200'
                    ],
                    [
                        'type' => 'presensi',
                        'title' => 'Laporan sakit Dewi Lestari diterima',
                        'desc' => 'Dikonfirmasi oleh orang tua melalui portal wali murid.',
                        'time' => '1 jam lalu',
                        'icon' => 'fa-shield-halved',
                        'color' => 'bg-blue-100 text-blue-600 border-blue-200'
                    ],
                    [
                        'type' => 'system',
                        'title' => 'Rekap Jam 1-4 telah disimpan',
                        'desc' => 'Jurnal kelas berhasil dikunci oleh sistem otomatis.',
                        'time' => '2 jam lalu',
                        'icon' => 'fa-circle-check',
                        'color' => 'bg-emerald-100 text-emerald-600 border-emerald-200'
                    ],
                    [
                        'type' => 'system',
                        'title' => 'Jadwal piket Anda diperbarui',
                        'desc' => 'Penugasan guru piket hari ini telah diverifikasi.',
                        'time' => 'Kemarin',
                        'icon' => 'fa-calendar-day',
                        'color' => 'bg-green-100 text-green-600 border-green-200'
                    ]
                ]);
                $activities = $activities->concat($mockActivities)->take(5);
            }

            return view('dashboard.gurupiket', compact('stats', 'absentStudents', 'activities'));
        }

        if ($loginRole === 'bk') {
            return view('dashboard.gurubk');
        }

        // TU Check (Move Higher)
        if (str_contains($pos, 'tata usaha') || str_contains($pos, 'tu')) {
            $hariMap = [
                'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
            ];
            $hariIni = $hariMap[now()->format('l')];
            $today = now()->toDateString();

            $kelasBelumPresensi = \App\Models\Jadwal::where('hari', $hariIni)
                ->whereDoesntHave('qrSessions', function($q) use ($today) {
                    $q->where('tanggal', $today);
                })
                ->distinct()
                ->pluck('kelas');

            $rekapAbsen = \App\Models\Presensi::with(['siswa', 'jadwal'])
                ->where('tanggal', $today)
                ->whereIn('status', ['Alfa', 'Izin', 'Sakit'])
                ->get()
                ->groupBy(function($p) {
                    return $p->jadwal->kelas ?? 'Umum';
                });

            return view('dashboard.tu', compact('kelasBelumPresensi', 'rekapAbsen'));
        }

        if ($loginRole === 'guru' || (str_contains($pos, 'guru') && $loginRole === 'umum')) {
            $hariMap = [
                'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
            ];
            $hariIni = $hariMap[now()->format('l')];
            $today = now()->toDateString();

            // Kelas yang belum presensi hari ini (berdasarkan jadwal)
            // Hanya ambil kelas yang ada di jadwal hari ini tapi belum ada QR Session
            $kelasBelumPresensi = \App\Models\Jadwal::where('hari', $hariIni)
                ->whereDoesntHave('qrSessions', function($q) use ($today) {
                    $q->where('tanggal', $today);
                })
                ->distinct()
                ->pluck('kelas');

            // Rekap siswa tidak masuk hari ini
            $rekapAbsen = \App\Models\Presensi::with(['siswa', 'jadwal'])
                ->where('tanggal', $today)
                ->whereIn('status', ['Alfa', 'Izin', 'Sakit'])
                ->get()
                ->groupBy(function($p) {
                    return $p->jadwal->kelas ?? 'Umum';
                });

            return view('dashboard.guru', compact('activeSession', 'kelasBelumPresensi', 'rekapAbsen'));
        }

        // Fallback berdasarkan position
        if (str_contains($pos, 'administrator')) return view('dashboard.admin');
        if (str_contains($pos, 'kepala sekolah')) return view('dashboard.admin');
        if (str_contains($pos, 'bk')) return view('dashboard.gurubk');
        if (str_contains($pos, 'guru') || str_contains($pos, 'waka') || str_contains($pos, 'kakonli')) return view('dashboard.guru', compact('activeSession', 'kelasBelumPresensi', 'rekapAbsen'));
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
        $siswa = auth('siswa')->user();
        $hariMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariIni = $hariMap[now()->format('l')];
        
        $jadwals = \App\Models\Jadwal::where('kelas', $siswa->kelas->nama_kelas)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();
            
        // Ambil status presensi hari ini
        $presensis = \App\Models\Presensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now())
            ->get()
            ->keyBy('jadwal_id');

        return view('siswa.dashboard', compact('jadwals', 'presensis'));
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
                // Rentang waktu aktif: dari jam mulai sampai jam selesai + 45 menit
                $end = \Carbon\Carbon::createFromFormat('H:i', $endStart, 'Asia/Jakarta')->addMinutes(45)->format('H:i');
                if ($nowTime >= $start && $nowTime <= $end) {
                    $activeJadwals[] = $j;
                }
            }
        }

        // Jika tidak ada jadwal yang pas dengan jam sekarang, tapi ada jadwal hari ini
        // Maka tampilkan semua jadwal hari ini sebagai pilihan
        if (count($activeJadwals) === 0 && count($jadwals) > 0 && !$request->jadwal_id) {
            return response()->json([
                'status' => 'multiple',
                'jadwals' => $jadwals,
                'message' => 'Silakan pilih jadwal yang ingin dimulai (di luar jam pelajaran).'
            ]);
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

        $session = \App\Models\QrSession::create([
            'jadwal_id' => $jadwal->id,
            'guru_id' => $user->id,
            'tanggal' => now()->toDateString(),
            'token' => $token,
            'expired_at' => $expiredAt,
        ]);

        $qrUrl = config('app.url') . '/siswa/scan/' . $token . '?ngrok-skip-browser-warning=true';
        $qrCode = (string) \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(300)->margin(1)->generate($qrUrl);

        return response()->json([
            'status' => 'success',
            'qr_code' => $qrCode,
            'token' => $token,
            'mapel' => $jadwal->mata_pelajaran,
            'kelas' => $jadwal->kelas,
            'hari'  => $jadwal->hari,
            'jam' => jamPelajaranToWaktu($jadwal->jam_mulai) . ' - ' . \Carbon\Carbon::createFromFormat('H:i', jamPelajaranToWaktu($jadwal->jam_selesai), 'Asia/Jakarta')->addMinutes(45)->format('H:i'),
            'expired_at' => $expiredAt->toDateTimeString(),
            'redirect_url' => route('guru.mulai.kelas', $session->id) . '?ngrok-skip-browser-warning=true'
        ]);
    }
}