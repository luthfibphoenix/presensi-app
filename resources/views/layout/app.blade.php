<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sistem Presensi SMKN7</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --safe-area-inset-top: env(safe-area-inset-top, 0px);
            --safe-area-inset-bottom: env(safe-area-inset-bottom, 0px);
        }

        @media (max-width: 768px) {
            main { 
                -webkit-overflow-scrolling: touch; 
                padding-bottom: calc(5rem + var(--safe-area-inset-bottom)) !important;
            }
            header {
                padding-top: var(--safe-area-inset-top) !important;
                height: calc(4rem + var(--safe-area-inset-top)) !important;
            }
            .mobile-nav {
                padding-bottom: env(safe-area-inset-bottom) !important;
            }
        }

        /* Sembunyikan scrollbar di semua browser */
        * {
            scrollbar-width: none;        /* Firefox */
            -ms-overflow-style: none;     /* IE & Edge */
        }
        *::-webkit-scrollbar {
            display: none;                /* Chrome, Safari, Opera */
        }

        /* Page transition */
        body {
            animation: fadeIn 0.25s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        body.page-leaving {
            animation: fadeOut 0.2s ease-in forwards;
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to   { opacity: 0; transform: translateY(-8px); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal loaded" 
      x-data="{ 
        activeRole: localStorage.getItem('activeRole') || '{{ auth('web')->check() ? 'guru' : (auth('siswa')->check() ? 'siswa' : 'none') }}',
        sidebarOpen: false
      }"
      x-init="$watch('activeRole', value => localStorage.setItem('activeRole', value))">
    
    <!-- Top Progress Loader -->
    <div id="page-loader" class="fixed top-0 left-0 z-[9999] h-[2px] bg-{{ $aksen ?? 'blue' }}-600 w-0 transition-all duration-300 ease-out"></div>
    
    <script>
        window.addEventListener('beforeunload', () => {
            document.body.classList.add('page-leaving');
            const loader = document.getElementById('page-loader');
            loader.style.width = '100%';
        });
        
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('page-loader');
            loader.style.width = '100%';
            setTimeout(() => {
                loader.style.opacity = '0';
            }, 300);
        });
    </script>

    @php
        $loginRole = auth('siswa')->check() ? 'siswa' : (auth('orangtua')->check() ? 'orangtua' : session('login_role', 'guru'));
        $user = auth()->user();
        
        // Unified Color System
        $roleConfig = [
            'piket' => ['color' => 'green', 'pill' => 'green'],
            'guru' => ['color' => 'blue', 'pill' => 'blue'],
            'siswa' => ['color' => 'teal', 'pill' => 'teal'],
            'orangtua' => ['color' => 'cyan', 'pill' => 'cyan'],
            'tu' => ['color' => 'violet', 'pill' => 'violet'],
            'admin' => ['color' => 'purple', 'pill' => 'purple'],
        ];

        $config = $roleConfig[$loginRole] ?? $roleConfig['guru'];
        $aksen = $config['color'];
        
        $initials = collect(explode(' ', $user->fullname ?? $user->nama))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('');
    @endphp

    <!-- Sidebar -->
    <x-sidebar :role="$loginRole" />

    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-[55] lg:hidden" 
         x-cloak></div>

    <div class="w-full lg:pl-72 min-h-screen bg-gray-50 flex flex-col h-[100dvh] relative overflow-hidden">
            <!-- Modern Seamless Sticky Header -->
            <header class="sticky top-0 z-[60] bg-white/95 backdrop-blur-md transition-all duration-300"
                    style="padding-top: var(--safe-area-inset-top); height: calc(5.5rem + var(--safe-area-inset-top));">
                <div class="h-full flex items-center justify-between px-6 md:px-10">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true" class="lg:hidden w-11 h-11 flex items-center justify-center rounded-2xl bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-all active:scale-90 shadow-sm border border-gray-100">
                            <i class="fas fa-bars-staggered text-lg"></i>
                        </button>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-{{ $aksen }}-600 uppercase tracking-[0.2em] leading-none mb-1.5 opacity-80">SMKN 7 Purworejo</span>
                            <h2 class="text-xl md:text-2xl font-black text-gray-900 tracking-tight leading-none">@yield('title', 'Dashboard')</h2>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 relative" id="userMenuContainer">
                        <button id="userMenuBtn" class="flex items-center gap-3 p-1 rounded-2xl hover:bg-gray-50 transition-all group focus:outline-none">
                            <div class="w-12 h-12 rounded-2xl overflow-hidden bg-{{ $aksen }}-100 flex items-center justify-center text-sm font-bold text-{{ $aksen }}-700 shadow-sm border-2 border-white ring-1 ring-{{ $aksen }}-100/50 transition-transform group-hover:scale-105">
                                @if(isset($user->photo_url) && $user->photo_url)
                                    @php
                                        $photo = $user->photo_url;
                                        if (str_contains($photo, 'drive.google.com')) {
                                            if (preg_match('/[-\w]{25,}/', $photo, $matches)) {
                                                $photo = "https://lh3.googleusercontent.com/d/" . $matches[0];
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $photo }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.parentElement.innerHTML='{{ $initials }}';">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            <div class="text-left hidden md:block">
                                <p class="text-sm font-black text-gray-900 leading-none mb-1.5">{{ explode(',', $user->fullname ?? $user->nama)[0] }}</p>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Online</p>
                                </div>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden py-1 animate-fade-in-up">
                            <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50">
                                <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Pengguna</p>
                                <p class="text-sm font-bold text-gray-800 truncate">{{ $user->fullname ?? $user->nama }}</p>
                            </div>
                            <a href="{{ auth('siswa')->check() ? route('siswa.profil') : route('profil') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-700 hover:bg-{{ $aksen }}-50 hover:text-{{ $aksen }}-700 transition">
                                <i class="fas fa-user-circle opacity-40"></i> Profil Saya
                            </a>
                            
                            @if($loginRole === 'guru' || $loginRole === 'piket')
                            @php
                                $activeSess = null;
                                if(auth('web')->check()){
                                    $activeSess = \App\Models\QrSession::where('guru_id', auth('web')->id())
                                        ->where('tanggal', now()->toDateString())
                                        ->where('expired_at', '>', now())
                                        ->first();
                                }
                            @endphp
                            @if($activeSess)
                            <div class="border-t border-gray-50 py-1">
                                <form action="{{ route('dashboard.end_session') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{ $activeSess->id }}">
                                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-sm text-red-600 hover:bg-red-50 transition text-left font-bold">
                                        <i class="fas fa-power-off"></i> Akhiri Kelas
                                    </button>
                                </form>
                            </div>
                            @endif
                            @endif

                            <div class="border-t border-gray-50 py-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-sm text-gray-400 hover:bg-gray-50 transition text-left font-semibold">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-100 no-scrollbar pb-32 md:pb-6">
                <div class="max-w-7xl mx-auto h-full flex flex-col">
                    @if (session('success') && !request()->routeIs('siswa.dashboard'))
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-3 mb-4 rounded-xl shadow-sm animate-page-content flex-shrink-0">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle"></i>
                                <span class="font-medium text-xs">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="animate-page-content flex-1 min-h-0">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    
    <!-- Mobile Bottom Navigation -->
    @auth
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-100 shadow-[0_-1px_12px_rgba(0,0,0,0.06)]"
         style="padding-bottom:env(safe-area-inset-bottom)">
        <div class="flex items-stretch h-16">
            @if($loginRole === 'siswa')
                {{-- Siswa: Home | Scan | Riwayat | Profil --}}
                @foreach([
                    ['label' => 'Home', 'route' => 'siswa.dashboard', 'icon' => 'fas fa-home'],
                    ['label' => 'Scan', 'route' => 'presensi.scan', 'icon' => 'fas fa-qrcode'],
                    ['label' => 'Riwayat', 'route' => 'siswa.riwayat', 'icon' => 'fas fa-history'],
                    ['label' => 'Profil', 'route' => 'siswa.profil', 'icon' => 'fas fa-user-circle'],
                ] as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex flex-col items-center justify-center flex-1 pt-1 transition-colors duration-200">
                        <span class="w-8 h-1 rounded-full mb-1 {{ request()->routeIs($item['route']) ? 'bg-'.$aksen.'-500' : 'bg-transparent' }}"></span>
                        <i class="{{ $item['icon'] }} text-[20px] {{ request()->routeIs($item['route']) ? 'text-'.$aksen.'-600' : 'text-gray-400' }}"></i>
                        <span class="text-[11px] mt-0.5 {{ request()->routeIs($item['route']) ? 'font-semibold text-'.$aksen.'-600' : 'font-normal text-gray-400' }}">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach
            @elseif($loginRole === 'piket')
                {{-- Piket: Beranda | Izin | Status | Laporan | Profil --}}
                @foreach([
                    ['label' => 'Beranda', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
                    ['label' => 'Izin', 'route' => 'izin.guru', 'icon' => 'fas fa-file-signature'],
                    ['label' => 'Status', 'route' => 'guru.qr.status.index', 'icon' => 'fas fa-clipboard-check'],
                    ['label' => 'Laporan', 'route' => 'laporan.index', 'icon' => 'fas fa-chart-pie'],
                    ['label' => 'Profil', 'route' => 'profil', 'icon' => 'fas fa-user-circle'],
                ] as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex flex-col items-center justify-center flex-1 pt-1 transition-colors duration-200">
                        <span class="w-8 h-1 rounded-full mb-1 {{ request()->routeIs($item['route']) ? 'bg-'.$aksen.'-500' : 'bg-transparent' }}"></span>
                        <i class="{{ $item['icon'] }} text-[20px] {{ request()->routeIs($item['route']) ? 'text-'.$aksen.'-600' : 'text-gray-400' }}"></i>
                        <span class="text-[11px] mt-0.5 {{ request()->routeIs($item['route']) ? 'font-semibold text-'.$aksen.'-600' : 'font-normal text-gray-400' }}">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach
            @elseif($loginRole === 'tu')
                {{-- TU: Beranda | SPD | Rekap | Siswa | Profil --}}
                @foreach([
                    ['label' => 'Beranda', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
                    ['label' => 'SPD', 'route' => 'tu.surat_dinas', 'icon' => 'fas fa-plane-departure'],
                    ['label' => 'Rekap', 'route' => 'laporan.rekap_harian', 'icon' => 'fas fa-calendar-check'],
                    ['label' => 'Siswa', 'route' => 'siswa.index', 'icon' => 'fas fa-users'],
                    ['label' => 'Profil', 'route' => 'profil', 'icon' => 'fas fa-user-circle'],
                ] as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex flex-col items-center justify-center flex-1 pt-1 transition-colors duration-200">
                        <span class="w-8 h-1 rounded-full mb-1 {{ request()->routeIs($item['route']) ? 'bg-'.$aksen.'-500' : 'bg-transparent' }}"></span>
                        <i class="{{ $item['icon'] }} text-[20px] {{ request()->routeIs($item['route']) ? 'text-'.$aksen.'-600' : 'text-gray-400' }}"></i>
                        <span class="text-[11px] mt-0.5 {{ request()->routeIs($item['route']) ? 'font-semibold text-'.$aksen.'-600' : 'font-normal text-gray-400' }}">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach
            @elseif($loginRole === 'orangtua')
                {{-- Ortu: Beranda | Histori | Izin | Profil --}}
                @foreach([
                    ['label' => 'Beranda', 'route' => 'ortu.dashboard', 'icon' => 'fas fa-house-chimney-window'],
                    ['label' => 'Histori', 'route' => 'ortu.kehadiran', 'icon' => 'fas fa-clock-rotate-left'],
                    ['label' => 'Izin', 'route' => 'ortu.izin', 'icon' => 'fas fa-envelope-open-text'],
                    ['label' => 'Profil', 'route' => 'ortu.profil', 'icon' => 'fas fa-user-circle'],
                ] as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex flex-col items-center justify-center flex-1 pt-1 transition-colors duration-200">
                        <span class="w-8 h-1 rounded-full mb-1 {{ request()->routeIs($item['route']) ? 'bg-'.$aksen.'-500' : 'bg-transparent' }}"></span>
                        <i class="{{ $item['icon'] }} text-[20px] {{ request()->routeIs($item['route']) ? 'text-'.$aksen.'-600' : 'text-gray-400' }}"></i>
                        <span class="text-[11px] mt-0.5 {{ request()->routeIs($item['route']) ? 'font-semibold text-'.$aksen.'-600' : 'font-normal text-gray-400' }}">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach
            @else
                {{-- Guru / Admin: Beranda | Jurnal | Status | Jadwal | Profil --}}
                @foreach([
                    ['label' => 'Beranda', 'route' => 'dashboard', 'icon' => 'fas fa-th-large'],
                    ['label' => 'Jurnal', 'route' => 'guru.jurnal.index', 'icon' => 'fas fa-book'],
                    ['label' => 'Status', 'route' => 'guru.qr.status.index', 'icon' => 'fas fa-clipboard-check'],
                    ['label' => 'Jadwal', 'route' => 'jadwal.hari.ini', 'icon' => 'fas fa-calendar-day'],
                    ['label' => 'Profil', 'route' => 'profil', 'icon' => 'fas fa-user-circle'],
                ] as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex flex-col items-center justify-center flex-1 pt-1 transition-colors duration-200">
                        <span class="w-8 h-1 rounded-full mb-1 {{ request()->routeIs($item['route']) ? 'bg-'.$aksen.'-500' : 'bg-transparent' }}"></span>
                        <i class="{{ $item['icon'] }} text-[20px] {{ request()->routeIs($item['route']) ? 'text-'.$aksen.'-600' : 'text-gray-400' }}"></i>
                        <span class="text-[11px] mt-0.5 {{ request()->routeIs($item['route']) ? 'font-semibold text-'.$aksen.'-600' : 'font-normal text-gray-400' }}">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach
            @endif
        </div>
    </nav>


    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Page Loader Management
            const body = document.body;
            body.classList.add('loaded');

            // Intercept all links for smooth exit
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && href !== '#' && !href.startsWith('javascript:') && !this.hasAttribute('target')) {
                        body.classList.remove('loaded');
                        body.classList.add('loading');
                    }
                });
            });

            // Dropdown Toggle
            const btn = document.getElementById('userMenuBtn');
            const dropdown = document.getElementById('userDropdown');

            if (btn && dropdown) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }

            // Sidebar Scroll Persistence
            const sidebarScroll = document.getElementById('main-sidebar-scroll');
            if (sidebarScroll) {
                const role = '{{ $loginRole }}';
                const scrollKey = 'sidebar-scroll-' + role;
                
                // Restore
                const savedScroll = localStorage.getItem(scrollKey);
                if (savedScroll) {
                    sidebarScroll.scrollTop = parseInt(savedScroll);
                }

                // Save on click (more reliable than beforeunload)
                sidebarScroll.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        localStorage.setItem(scrollKey, sidebarScroll.scrollTop);
                    });
                });
            }

            // Student Auto-Logout (5 Minutes Inactivity)
            @if(auth('siswa')->check())
                let inactivityTimer;
                const logoutTime = 5 * 60 * 1000; // 5 minutes

                function resetTimer() {
                    clearTimeout(inactivityTimer);
                    inactivityTimer = setTimeout(() => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('logout') }}';
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);
                        document.body.appendChild(form);
                        form.submit();
                    }, logoutTime);
                }

                window.onload = resetTimer;
                document.onmousemove = resetTimer;
                document.onmousedown = resetTimer;
                document.ontouchstart = resetTimer;
                document.onclick = resetTimer;
                document.onkeydown = resetTimer;
                document.addEventListener('scroll', resetTimer, true);
            @endif

            // Page Transition & Loader
            const loader = document.getElementById('page-loader');
            document.querySelectorAll('a[href]').forEach(link => {
                if (
                    link.hostname !== location.hostname || 
                    link.getAttribute('href').startsWith('#') ||
                    link.getAttribute('href').startsWith('javascript:') ||
                    link.target === '_blank' ||
                    link.hasAttribute('download')
                ) return;

                link.addEventListener('click', function(e) {
                    const href = this.href;
                    if (href === location.href + '#' || href === location.href) return;
                    
                    e.preventDefault();
                    if (loader) loader.style.width = '70%';
                    document.body.classList.add('page-leaving');
                    setTimeout(() => { window.location.href = href; }, 150);
                });
            });

            window.addEventListener('beforeunload', () => {
                if (loader) loader.style.width = '100%';
            });
        });
    </script>
    @stack('modals')
    @stack('scripts')
</body>
</html>
