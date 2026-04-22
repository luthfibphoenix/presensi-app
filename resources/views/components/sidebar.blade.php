@props(['role' => 'guru'])

@php
    $user = auth('web')->user() ?? auth('siswa')->user();
    $name = $user->fullname ?? $user->nama ?? 'User';
    $position = ($role === 'siswa') ? 'Siswa' : ($user->position ?? 'Guru');
    
     $pos = strtolower($user->position ?? '');
    if ($role === 'siswa' || str_contains($pos, 'siswa')) {
        $bgSidebar = 'bg-emerald-900';
        $bgActive = 'bg-emerald-700/50';
    } elseif (str_contains($pos, 'kepala sekolah')) {
        $bgSidebar = 'bg-zinc-950';
        $bgActive = 'bg-zinc-800/50';
    } elseif (str_contains($pos, 'piket')) {
        $bgSidebar = 'bg-orange-700';
        $bgActive = 'bg-orange-600/50';
    } elseif ($role === 'admin' || str_contains($pos, 'admin') || str_contains($pos, 'administrator')) {
        $bgSidebar = 'bg-purple-900';
        $bgActive = 'bg-purple-700/50';
    } else {
        $bgSidebar = 'bg-blue-900';
        $bgActive = 'bg-blue-700/50';
    }

    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=fff&color=333&bold=true&size=128';
    $photoUrl = $user->photo_url ?? $fallbackUrl;

    $menus = [];
    $isSuperAdmin = str_contains($pos, 'super administrator');

    if ($isSuperAdmin) {
        $bgSidebar = 'bg-slate-900';
        $bgActive = 'bg-blue-600/50';
        $menus = [
            'DASHBOARD' => [
                ['label' => 'Admin Panel', 'route' => 'dashboard', 'icon' => 'fas fa-shield-alt'],
                ['label' => 'Dashboard Siswa', 'route' => 'siswa.dashboard', 'icon' => 'fas fa-user-graduate'],
            ],
            'MANAJEMEN DATA' => [
                ['label' => 'Data Guru', 'route' => 'guru.index', 'icon' => 'fas fa-chalkboard-teacher'],
                ['label' => 'Data Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-users'],
                ['label' => 'Data Kelas', 'route' => 'kelas.index', 'icon' => 'fas fa-school'],
                ['label' => 'Data Mapel', 'route' => 'admin.mapel.index', 'icon' => 'fas fa-book-open'],
                ['label' => 'Jadwal Induk', 'route' => 'jadwal.index', 'icon' => 'fas fa-calendar-alt'],
            ],
            'LAYANAN AKADEMIK' => [
                ['label' => 'Jurnal Mengajar', 'route' => 'guru.jurnal.index', 'icon' => 'fas fa-book'],
                ['label' => 'Penilaian Guru', 'route' => 'guru.penilaian.index', 'icon' => 'fas fa-star'],
                ['label' => 'Catatan Siswa', 'route' => 'guru.catatan.index', 'icon' => 'fas fa-sticky-note'],
                ['label' => 'Cetak Blangko', 'route' => 'guru.blangko.index', 'icon' => 'fas fa-print'],
            ],
            'PRESENSI & LAPORAN' => [
                ['label' => 'Scan QR', 'route' => 'presensi.scan', 'icon' => 'fas fa-qrcode'],
                ['label' => 'Status Kehadiran', 'route' => 'guru.qr.status.index', 'icon' => 'fas fa-clipboard-check'],
                ['label' => 'Izin Guru/Siswa', 'route' => 'izin.guru', 'icon' => 'fas fa-file-signature'],
                ['label' => 'Rekap Harian', 'route' => 'laporan.rekap_harian', 'icon' => 'fas fa-calendar-check'],
                ['label' => 'Laporan Global', 'route' => 'laporan.index', 'icon' => 'fas fa-chart-line'],
            ],
            'SISTEM' => [
                ['label' => 'Reset Password', 'route' => 'admin.password.index', 'icon' => 'fas fa-key'],
                ['label' => 'Surat Dinas (SPD)', 'route' => 'tu.surat_dinas', 'icon' => 'fas fa-plane-departure'],
                ['label' => 'Surat Panggilan BK', 'route' => 'bk.surat_panggil', 'icon' => 'fas fa-envelope-open-text'],
            ],
        ];
    } elseif ($role === 'admin' || str_contains($pos, 'administrator')) {
        $menus = [
            'UTAMA' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'MANAJEMEN' => [
                ['label' => 'Manajemen Guru', 'route' => 'guru.index', 'icon' => 'fas fa-chalkboard-teacher'],
                ['label' => 'Manajemen Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-user-graduate'],
                ['label' => 'Manajemen Kelas', 'route' => 'kelas.index', 'icon' => 'fas fa-school'],
                ['label' => 'Manajemen Mapel', 'route' => 'admin.mapel.index', 'icon' => 'fas fa-book-open'],
                ['label' => 'Jadwal', 'route' => 'jadwal.index', 'icon' => 'fas fa-calendar-alt'],
            ],
            'ADMINISTRASI' => [
                ['label' => 'Rekap Jurnal', 'route' => 'admin.jurnal', 'icon' => 'fas fa-book'],
                ['label' => 'Reset Password', 'route' => 'admin.password.index', 'icon' => 'fas fa-key'],
                ['label' => 'Rekap Harian', 'route' => 'laporan.rekap_harian', 'icon' => 'fas fa-calendar-check'],
                ['label' => 'Laporan Kehadiran', 'route' => 'laporan.index', 'icon' => 'fas fa-chart-line'],
            ],
        ];
    } elseif (str_contains($pos, 'tata usaha') || str_contains($pos, 'tu')) {
        $menus = [
            'UTAMA' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'ADMINISTRASI TU' => [
                ['label' => 'Surat Dinas (SPPD)', 'route' => 'tu.surat_dinas', 'icon' => 'fas fa-plane-departure'],
                ['label' => 'Database Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-users'],
                ['label' => 'Rekap Harian', 'route' => 'laporan.rekap_harian', 'icon' => 'fas fa-calendar-check'],
            ],
        ];
    } elseif (str_contains($pos, 'bk') || str_contains($pos, 'bimbingan konseling')) {
        $menus = [
            'UTAMA' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'LAYANAN PRESENSI' => [
                ['label' => 'Jadwal Hari Ini', 'route' => 'jadwal.hari.ini', 'icon' => 'fas fa-calendar-day'],
                ['label' => 'Semua Jadwal', 'route' => 'jadwal.semua', 'icon' => 'fas fa-calendar-alt'],
                ['label' => 'Status Kehadiran', 'route' => 'guru.qr.status.index', 'icon' => 'fas fa-clipboard-check'],
            ],
            'LAYANAN BK' => [
                ['label' => 'Surat Pemanggilan', 'route' => 'bk.surat_panggil', 'icon' => 'fas fa-envelope-open-text'],
                ['label' => 'Database Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-users'],
                ['label' => 'Catatan Siswa', 'route' => 'guru.catatan.index', 'icon' => 'fas fa-sticky-note'],
            ],
        ];
    } elseif ($role === 'piket' || str_contains($pos, 'piket')) {
        $menus = [
            'UTAMA' => [
                ['label' => 'Beranda', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
                ['label' => 'Surat Izin Siswa', 'route' => 'izin.guru', 'icon' => 'fas fa-file-signature'],
                ['label' => 'Rekap Harian', 'route' => 'laporan.rekap_harian', 'icon' => 'fas fa-calendar-check'],
                ['label' => 'Laporan Kehadiran', 'route' => 'laporan.index', 'icon' => 'fas fa-chart-line'],
            ],
        ];
    } elseif ($role === 'siswa') {
        $menus = [
            'UTAMA' => [
                ['label' => 'Beranda', 'route' => 'siswa.dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'LAYANAN SISWA' => [
                ['label' => 'Scan QR Absen', 'route' => 'presensi.scan', 'icon' => 'fas fa-qrcode'],
                ['label' => 'Riwayat Kehadiran', 'route' => 'siswa.riwayat', 'icon' => 'fas fa-history'],
                ['label' => 'Pengajuan Izin', 'route' => 'izin.index', 'icon' => 'fas fa-file-signature'],
            ]
        ];
    } elseif ($role === 'kepala_sekolah' || str_contains(strtolower($user->position ?? ''), 'kepala sekolah')) {
        $menus = [
            'UTAMA' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'MONITORING' => [
                ['label' => 'Manajemen Guru', 'route' => 'guru.index', 'icon' => 'fas fa-chalkboard-teacher'],
                ['label' => 'Manajemen Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-user-graduate'],
                ['label' => 'Jadwal Sekolah', 'route' => 'jadwal.index', 'icon' => 'fas fa-calendar-alt'],
            ],
            'LAPORAN GLOBAL' => [
                ['label' => 'Laporan Kehadiran', 'route' => 'laporan.index', 'icon' => 'fas fa-chart-line'],
                ['label' => 'Rekap Harian', 'route' => 'laporan.rekap_harian', 'icon' => 'fas fa-calendar-check'],
                ['label' => 'Rekap Jurnal', 'route' => 'admin.jurnal', 'icon' => 'fas fa-book'],
                ['label' => 'Izin Guru/Siswa', 'route' => 'izin.guru', 'icon' => 'fas fa-file-signature'],
            ],
        ];
    } else {
        $menus = [
            'UTAMA' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'AKADEMIK' => [
                ['label' => 'Jurnal Saya', 'route' => 'guru.jurnal.index', 'icon' => 'fas fa-book'],
                ['label' => 'Penilaian', 'route' => 'guru.penilaian.index', 'icon' => 'fas fa-star'],
                ['label' => 'Catatan Siswa', 'route' => 'guru.catatan.index', 'icon' => 'fas fa-sticky-note'],
            ],
            'LAYANAN PRESENSI' => [
                ['label' => 'Jadwal Hari Ini', 'route' => 'jadwal.hari.ini', 'icon' => 'fas fa-calendar-day'],
                ['label' => 'Semua Jadwal', 'route' => 'jadwal.semua', 'icon' => 'fas fa-calendar-alt'],
                ['label' => 'Status Kehadiran', 'route' => 'guru.qr.status.index', 'icon' => 'fas fa-clipboard-check'],
            ],
            'ADMINISTRASI GURU' => array_filter([
                ['label' => 'Cetak Cover', 'route' => 'guru.blangko.cover', 'icon' => 'fas fa-file-alt'],
                ['label' => 'Cetak Blangko', 'route' => 'guru.blangko.index', 'icon' => 'fas fa-print'],
                $user->is_wali ? ['label' => 'Siswa Wali', 'route' => 'siswa.index', 'icon' => 'fas fa-users'] : null,
            ]),
        ];

        if ($user->is_wali === true) {
            // Keep Siswa Wali
        } else {
            $menus['ADMINISTRASI'] = array_filter($menus['ADMINISTRASI'], function($item) {
                return $item['label'] !== 'Siswa Wali';
            });
        }
    }
@endphp

<aside id="main-sidebar" 
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed top-0 left-0 w-72 {{ $bgSidebar }} text-white flex flex-col transition-transform duration-300 z-[60] h-screen overflow-hidden -translate-x-full lg:translate-x-0 {{ auth('siswa')->check() ? 'hidden lg:flex' : 'flex' }}">
    
    <div class="flex-shrink-0">
        <!-- Logo Section -->
        <div class="h-16 flex items-center justify-between px-8 border-b border-white/10">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-kanan.png') }}" alt="Logo SMKN7" class="w-9 h-9 rounded-full object-contain bg-white p-0.5 flex-shrink-0">
                <div class="leading-tight">
                    <span class="text-white font-black text-sm tracking-tight uppercase block">SMK Negeri 7</span>
                    <span class="text-white/60 font-bold text-[10px] uppercase tracking-widest block">Purworejo</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-white/50 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- User Profile Section -->
        <div class="px-8 py-10 flex flex-col items-center border-b border-white/10">
            <img src="{{ $photoUrl }}" alt="Profile" class="w-20 h-20 rounded-full object-cover border-4 border-white/20 mb-4">
            <h3 class="text-white font-bold text-center text-sm leading-tight mb-2">{{ $name }}</h3>
            @if($role === 'piket')
                <div class="flex flex-col items-center gap-1.5">
                    <span class="px-3 py-1 bg-white text-orange-700 text-[10px] font-black uppercase rounded-full tracking-widest shadow-lg">
                        Mode Piket Aktif
                    </span>
                    <span class="text-[10px] font-bold text-orange-100 uppercase tracking-tighter">
                        {{ $position }}
                    </span>
                </div>
            @elseif(str_contains(strtolower($user->position ?? ''), 'super administrator'))
                <div class="flex flex-col items-center gap-1.5">
                    <span class="px-3 py-1 bg-red-600 text-white text-[10px] font-black uppercase rounded-full tracking-widest shadow-lg">
                        Super Administrator
                    </span>
                </div>
            @elseif(str_contains(strtolower($user->position ?? ''), 'kepala sekolah'))
                <div class="flex flex-col items-center gap-1.5">
                    <span class="px-3 py-1 bg-amber-500 text-white text-[10px] font-black uppercase rounded-full tracking-widest shadow-lg">
                        Kepala Sekolah
                    </span>
                </div>
            @else
                <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest">{{ $position }}</span>
            @endif
        </div>
    </div>

    <!-- Navigation Menu -->
    <div id="main-sidebar-scroll" class="flex-1 overflow-y-auto no-scrollbar py-6">
        @foreach($menus as $section => $items)
            <div class="mb-8 px-8">
                <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-4">{{ $section }}</p>
                <div class="space-y-1">
                    @foreach($items as $item)
                        @php
                            $isActive = request()->routeIs($item['route']);
                        @endphp
                        <a href="{{ route($item['route']) }}" 
                           class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 group {{ $isActive ? $bgActive . ' text-white shadow-lg' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                            <i class="{{ $item['icon'] }} text-lg transition-transform duration-300 group-hover:scale-110 {{ $isActive ? 'text-white' : 'text-white/40' }}"></i>
                            <span class="text-sm font-bold tracking-wide">{{ $item['label'] }}</span>
                            @if($isActive)
                                <div class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</aside>
