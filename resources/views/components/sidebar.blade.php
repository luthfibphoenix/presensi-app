@props(['role' => 'guru'])

@php
    $user = auth('web')->user() ?? auth('siswa')->user();
    $name = $user->fullname ?? $user->nama ?? 'User';
    $position = ($role === 'siswa') ? 'Siswa' : ($user->position ?? 'Guru');
    if ($role === 'piket') $position = 'Guru Piket';
    if ($role === 'admin') $position = 'Administrator';
    
    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=3B82F6&color=fff&bold=true&size=128';
    $photoUrl = $user->photo_url ?? $fallbackUrl;

    $menus = [];
    
    if ($role === 'admin') {
        $menus = [
            'UTAMA' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
            ],
            'MANAJEMEN' => [
                ['label' => 'Manajemen Guru', 'route' => 'guru.index', 'icon' => 'fas fa-chalkboard-teacher'],
                ['label' => 'Manajemen Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-user-graduate'],
                ['label' => 'Manajemen Kelas', 'route' => 'kelas.index', 'icon' => 'fas fa-school'],
                ['label' => 'Jadwal', 'route' => 'jadwal.index', 'icon' => 'fas fa-calendar-alt'],
            ],
            'LAPORAN' => [
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
                ['label' => 'Catatan Siswa', 'route' => 'dashboard', 'icon' => 'fas fa-sticky-note'],
                ['label' => 'Cetak Blangko', 'route' => 'guru.blangko.index', 'icon' => 'fas fa-print'],
            ],
        ];

        // Only TU, Administrator, and Guru BK can access Database Siswa
        $pos = strtolower($user->position ?? '');
        $isAuthorized = $role === 'admin' || $role === 'bk' || 
                        str_contains($pos, 'tata usaha') || 
                        str_contains($pos, 'tu') || 
                        str_contains($pos, 'bk') || 
                        str_contains($pos, 'administrator');

        if ($isAuthorized) {
            $menus['DATABASE'] = [
                ['label' => 'Database Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-users'],
            ];
        }
    }
@endphp

<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
     class="fixed w-64 bg-[#1e293b] text-white flex flex-col transition-transform duration-300 z-50 h-screen overflow-y-auto">
    
    <!-- Logo Section -->
    <div class="h-16 flex items-center px-6 flex-shrink-0">
        <span class="text-white font-black text-xl tracking-tight">PRESENSI APP</span>
    </div>

    <!-- User Profile Section -->
    <div class="px-6 py-8 flex flex-col items-center">
        <img src="{{ $photoUrl }}" 
             alt="Profile" 
             class="w-20 h-20 rounded-full object-cover border-4 border-gray-400/30 shadow-lg mb-4">
        <h3 class="text-white font-bold text-center text-sm leading-tight mb-2">{{ $name }}</h3>
        <span class="px-3 py-1 bg-blue-600 text-[10px] font-bold uppercase rounded-full tracking-wider">
            {{ strtoupper($position) }}
        </span>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-grow overflow-y-auto px-0 py-4 no-scrollbar">
        <nav class="space-y-6">
            @foreach($menus as $section => $items)
            <div>
                <h4 class="px-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">{{ $section }}</h4>
                <ul class="space-y-0">
                    @foreach($items as $item)
                    @php
                        $isActive = request()->routeIs($item['route']);
                    @endphp
                    <li>
                        <a href="{{ route($item['route']) }}" 
                           class="flex items-center gap-4 px-6 py-3.5 transition-all duration-200 {{ $isActive ? 'bg-[#3b82f6] text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                            <i class="{{ $item['icon'] }} w-5 text-center"></i>
                            <span class="text-sm font-medium">{{ $item['label'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </nav>
    </div>
</div>
