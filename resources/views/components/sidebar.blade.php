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
    
    if ($role === 'admin' || str_contains($pos, 'administrator')) {
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
            ],
        ];
    } elseif (str_contains($pos, 'bk') || str_contains($pos, 'bimbingan konseling')) {
        $menus = [
            'UTAMA' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
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
                ['label' => 'Pengajuan Izin', 'route' => 'izin.guru', 'icon' => 'fas fa-file-signature'],
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
                ['label' => 'Rekap Jurnal', 'route' => 'admin.jurnal', 'icon' => 'fas fa-book'],
                ['label' => 'Izin Guru/Siswa', 'route' => 'izin.guru', 'icon' => 'fas fa-file-signature'],
            ],
        ];
    } else {
        $menus = [
            'UTAMA' => [
                ['label' => 'Beranda', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'LAYANAN PRESENSI' => [
                ['label' => 'Jadwal Hari Ini', 'route' => 'jadwal.hari.ini', 'icon' => 'fas fa-calendar-day'],
                ['label' => 'Semua Jadwal', 'route' => 'jadwal.semua', 'icon' => 'fas fa-calendar-alt'],
                ['label' => 'Status Kehadiran', 'route' => 'guru.qr.status.index', 'icon' => 'fas fa-clipboard-check'],
            ],
            'AKADEMIK' => [
                ['label' => 'Jurnal Saya', 'route' => 'guru.jurnal.index', 'icon' => 'fas fa-book'],
                ['label' => 'Penilaian', 'route' => 'guru.penilaian.index', 'icon' => 'fas fa-star'],
                ['label' => 'Catatan Siswa', 'route' => 'guru.catatan.index', 'icon' => 'fas fa-sticky-note'],
                ['label' => 'Cetak Blangko', 'route' => 'guru.blangko.index', 'icon' => 'fas fa-print'],
            ],
        ];

        $pos = strtolower($user->position ?? '');
        $isAuthorized = $role === 'admin' || $role === 'bk' || str_contains($pos, 'tata usaha') || str_contains($pos, 'tu') || str_contains($pos, 'bk') || str_contains($pos, 'administrator');
        if ($isAuthorized) {
            $menus['DATABASE'] = [['label' => 'Database Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-users']];
        }
    }
@endphp

<aside id="main-sidebar" 
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed top-0 left-0 w-64 {{ $bgSidebar }} text-white flex flex-col transition-transform duration-300 z-[60] h-screen overflow-hidden -translate-x-full lg:translate-x-0 {{ auth('siswa')->check() ? 'hidden lg:flex' : 'flex' }}">
    
    <div class="flex-shrink-0">
        <!-- Logo Section -->
        <div class="h-16 flex items-center justify-between px-8 border-b border-white/10">
            <div class="flex items-center gap-3">
                <span class="text-white font-black text-xl tracking-tight uppercase">Presensi App</span>
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
            @elseif(str_contains(strtolower($user->position ?? ''), 'kepala sekolah'))
                <div class="flex flex-col items-center gap-1.5">
                    <span class="px-3 py-1 bg-amber-500 text-white text-[10px] font-black uppercase rounded-full tracking-widest shadow-lg">
                        Kepala Sekolah
                    </span>
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-tighter">
                        SMKN 7 Pontianak
                    </span>
                </div>
            @else
                <span class="px-3 py-1 bg-white/20 text-white text-[10px] font-bold uppercase rounded-full tracking-widest">
                    {{ strtoupper($position) }}
                </span>
            @endif
        </div>
    </div>

    <!-- Navigation Menu -->
    <div id="main-sidebar-scroll" class="flex-grow overflow-y-auto no-scrollbar py-6">
        <nav class="space-y-6">
            @foreach($menus as $section => $items)
            <div>
                <h4 class="px-8 text-[10px] font-bold text-white/40 uppercase tracking-widest mb-4">{{ $section }}</h4>
                <ul class="space-y-1">
                    @foreach($items as $item)
                    @php $isActive = request()->routeIs($item['route']); @endphp
                    <li>
                        <a href="{{ route($item['route']) }}" 
                           class="group flex items-center gap-4 px-8 py-3.5 transition-all duration-300 {{ $isActive ? $bgActive . ' border-l-4 border-white' : 'text-white/70 hover:bg-white/5 hover:text-white hover:pl-10' }}">
                            <i class="{{ $item['icon'] }} w-5 text-center text-sm transition-transform group-hover:scale-110"></i>
                            <span class="text-sm font-medium transition-all group-hover:tracking-wide">{{ $item['label'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </nav>
    </div>
</aside>
