@props(['role' => session('login_role', 'guru')])

@php
    $user = auth('web')->user() ?? auth('siswa')->user();
    $name = $user->fullname ?? $user->nama ?? 'User';
    $displayPosition = $user->position ?? match($role) {
        'siswa' => 'Siswa',
        'piket' => 'Guru Piket',
        'admin' => 'Administrator',
        'bk' => 'Guru BK',
        'tu' => 'Tata Usaha',
        default => 'Guru'
    };
    $pos = strtolower($user->position ?? '');
    
    // Gunakan $role dari session untuk menentukan warna
    if ($role === 'siswa') {
        $bgSidebar = 'bg-[#062421]';
        $bgActive = 'bg-[#0f443e]';
    } elseif ($role === 'admin' || str_contains($pos, 'administrator')) {
        $bgSidebar = 'bg-[#1b092b]';
        $bgActive = 'bg-[#3b1c55]';
    } elseif ($role === 'piket') {
        $bgSidebar = 'bg-[#0B301E]'; // matching screenshot
        $bgActive = 'bg-[#185237]';  // matching screenshot
    } elseif ($role === 'bk') {
        $bgSidebar = 'bg-[#09090b]';
        $bgActive = 'bg-[#27272a]';
    } elseif ($role === 'tu') {
        $bgSidebar = 'bg-[#1c0c30]';
        $bgActive = 'bg-[#371e5c]';
    } else {
        $bgSidebar = 'bg-[#0b1e30]'; 
        $bgActive = 'bg-[#1a3857]';
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
    } elseif ($role === 'tu') {
        $menus = [
            'UTAMA' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'ADMINISTRASI TU' => [
                ['label' => 'Surat Dinas (SPPD)', 'route' => 'tu.surat_dinas', 'icon' => 'fas fa-plane-departure'],
                ['label' => 'Database Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-users'],
            ],
        ];
    } elseif ($role === 'bk') {
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
    } elseif ($role === 'piket') {
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
            ]
        ];
    } elseif ($role === 'kepala_sekolah') {
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
    }
@endphp

<aside id="main-sidebar" 
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed top-0 left-0 w-64 h-screen {{ $bgSidebar }} text-white flex flex-col transition-transform duration-300 z-[60] overflow-hidden -translate-x-full lg:translate-x-0 {{ auth('siswa')->check() ? 'hidden lg:flex' : 'flex' }}">
    
    <div class="flex-shrink-0">
        <!-- Logo Section -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-white/5">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-kanan.png') }}" alt="Logo SMKN7" class="w-8 h-8 rounded-full object-contain bg-white p-0.5 flex-shrink-0">
                <div class="leading-tight">
                    <span class="text-white font-black text-xs tracking-tight uppercase block">SMK Negeri 7</span>
                    <span class="text-white/60 font-bold text-[9px] uppercase tracking-widest block">Purworejo</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-white/50 hover:text-white transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div id="main-sidebar-scroll" class="flex-1 overflow-y-auto no-scrollbar py-6">
        @foreach($menus as $section => $items)
            <div class="mb-6 px-6">
                <p class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em] mb-3">{{ $section }}</p>
                <div class="space-y-1">
                    @foreach($items as $item)
                        @php
                            $isActive = request()->routeIs($item['route']);
                        @endphp
                        <a href="{{ route($item['route']) }}" 
                           class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 group {{ $isActive ? $bgActive . ' text-white shadow-md' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                            <i class="{{ $item['icon'] }} text-sm transition-transform duration-300 group-hover:scale-110 {{ $isActive ? 'text-white' : 'text-white/30' }}"></i>
                            <span class="text-xs font-bold tracking-wide">{{ $item['label'] }}</span>
                            @if($isActive)
                                <div class="ml-auto w-1 h-1 bg-white rounded-full"></div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- User Profile Bottom Widget -->
    <div class="mt-auto border-t border-white/5 p-4 bg-black/10 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-3 min-w-0">
            <img src="{{ $photoUrl }}" alt="Profile" class="w-9 h-9 rounded-full object-cover border border-white/10 shrink-0">
            <div class="leading-tight min-w-0">
                <h4 class="text-xs font-black text-white truncate">{{ $name }}</h4>
                <p class="text-[9px] font-bold text-white/50 uppercase tracking-widest truncate">{{ $displayPosition }}</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="shrink-0 flex">
            @csrf
            <button type="submit" class="text-white/40 hover:text-rose-400 p-2 rounded-lg transition-colors" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</aside>
