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
            'ADMINISTRASI GURU' => [
                ['label' => 'Cetak Cover', 'route' => 'guru.blangko.cover', 'icon' => 'fas fa-file-alt'],
                ['label' => 'Cetak Blangko', 'route' => 'guru.blangko.index', 'icon' => 'fas fa-print'],
                ['label' => 'Siswa Wali', 'route' => 'siswa.index', 'icon' => 'fas fa-users'],
            ],
        ];
    }
@endphp

<aside id="main-sidebar" 
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed top-0 left-0 w-72 {{ $bgSidebar }} text-white flex flex-col transition-transform duration-300 z-[60] h-screen overflow-hidden -translate-x-full lg:translate-x-0 {{ auth('siswa')->check() ? 'hidden lg:flex' : 'flex' }}">
    
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
                    <li class="px-4 relative group">
                        @if($isActive)
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-white rounded-r-full shadow-[0_0_15px_rgba(255,255,255,0.5)] z-10 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"></div>
                        @endif
                        <a href="{{ route($item['route']) }}" 
                           class="group flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] active:scale-[0.95] {{ $isActive ? 'bg-white/10 ring-1 ring-white/20 shadow-xl backdrop-blur-md' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-2' }}">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] {{ $isActive ? 'bg-white text-blue-900 shadow-[0_0_20px_rgba(255,255,255,0.3)]' : 'bg-white/5 text-white/40 group-hover:bg-white/20 group-hover:text-white' }}">
                                <i class="{{ $item['icon'] }} text-sm"></i>
                            </div>
                            <span class="text-sm font-black tracking-tight transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] {{ $isActive ? 'text-white' : 'text-white/50 group-hover:text-white' }}">{{ $item['label'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </nav>
    </div>
</aside>
