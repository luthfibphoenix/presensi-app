<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi SMKN7</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Ultra Smooth Liquid Page Transitions */
        @keyframes liquidFadeIn {
            0% { opacity: 0; transform: translateY(20px) scale(0.98); filter: blur(10px); }
            100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }
        .animate-page-content {
            animation: liquidFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Top Progress Bar Animation */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, #3b82f6, #06b6d4);
            z-index: 9999;
            transform: translateX(-100%);
            transition: transform 0.4s ease;
        }
        .loading #page-loader {
            transform: translateX(-20%);
            transition: transform 10s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .loaded #page-loader {
            transform: translateX(0);
            transition: transform 0.3s ease;
        }

        [x-cloak] { display: none !important; }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        @media (max-width: 768px) {
            main { -webkit-overflow-scrolling: touch; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal loaded" 
      x-data="{ 
        activeRole: localStorage.getItem('activeRole') || '{{ auth('web')->check() ? 'guru' : (auth('siswa')->check() ? 'siswa' : 'none') }}',
        sidebarOpen: false
      }"
      x-init="$watch('activeRole', value => localStorage.setItem('activeRole', value))">
    
    <!-- Top Progress Bar -->
    <div id="page-loader"></div>

    <div class="h-screen bg-gray-50 flex overflow-hidden">
        
        <!-- Sidebar -->
        @php
            $currentRole = auth('siswa')->check() ? 'siswa' : session('login_role', 'guru');
        @endphp
        <x-sidebar :role="$currentRole" />

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

        <!-- Main Content Wrapper -->
        <div class="flex-1 lg:ml-72 flex flex-col h-screen relative overflow-hidden">
            <!-- Fixed Top Navbar -->
            <header class="h-16 bg-white shadow-sm border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0 z-10">
                <div class="flex items-center gap-4">
                    @if(!auth('siswa')->check())
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    @endif
                    <h2 class="text-lg font-bold text-gray-800 tracking-tight">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-4 relative" id="userMenuContainer">
                    <button id="userMenuBtn" class="flex items-center gap-4 focus:outline-none group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-900 dark:text-white leading-none mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ auth()->user()->fullname ?? auth()->user()->nama }}</p>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ auth()->user()->position ?? 'Siswa' }}</p>
                        </div>
                        @php
                            $userPhoto = auth()->user()->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->fullname ?? auth()->user()->nama) . '&background=f3f4f6&color=6b7280&bold=true';
                        @endphp
                        <img src="{{ $userPhoto }}" 
                             alt="User" 
                             class="w-10 h-10 rounded-full border-2 border-white dark:border-slate-800 object-cover shadow-sm group-hover:border-blue-400 dark:group-hover:border-blue-500 transition-all duration-300">
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="hidden absolute right-0 top-full mt-3 w-64 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 z-50 overflow-hidden py-1 animate-fade-in-up">
                        <div class="px-6 py-5 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.3em] mb-2">Pengguna</p>
                            <p class="text-sm font-black text-slate-800 dark:text-white truncate">{{ auth()->user()->fullname ?? auth()->user()->nama }}</p>
                        </div>
                        <a href="{{ auth('siswa')->check() ? route('siswa.profil') : route('profil') }}" 
                           class="flex items-center gap-3 px-6 py-4 text-sm text-slate-600 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 dark:hover:text-blue-400 transition-all">
                            <i class="fas fa-user-circle text-lg opacity-40"></i> 
                            <span class="font-bold">Profil Saya</span>
                        </a>

                        @php
                            $user = auth()->user();
                            $activeSess = null;
                            if ($user && auth('web')->check()) {
                                $activeSess = \App\Models\QrSession::where('guru_id', $user->id)
                                    ->where('tanggal', now()->toDateString())
                                    ->where('expired_at', '>', now())
                                    ->first();
                            }
                        @endphp

                        @if($activeSess)
                        <div class="border-t border-slate-50 dark:border-slate-800 py-1">
                            <form action="{{ route('dashboard.end_session') }}" method="POST" onsubmit="return confirm('Akhiri sesi kelas sekarang? Siswa yang belum absen akan otomatis dicatat Alfa.')">
                                @csrf
                                <input type="hidden" name="session_id" value="{{ $activeSess->id }}">
                                <button type="submit" class="w-full flex items-center gap-3 px-6 py-4 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 transition text-left font-black">
                                    <i class="fas fa-power-off"></i> Akhiri Kelas
                                </button>
                            </form>
                        </div>
                        @endif

                        <div class="border-t border-slate-50 dark:border-slate-800 py-1">
                            <form action="{{ auth('siswa')->check() ? route('siswa.logout') : route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-6 py-4 text-sm text-slate-400 dark:text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition text-left font-bold">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-slate-50 dark:bg-slate-950 no-scrollbar relative">
                <div class="max-w-7xl mx-auto h-full flex flex-col">
                    @if (session('success'))
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
    </div>
    
    <!-- Mobile Bottom Navigation -->
    @auth
    @php
        $userPos = strtolower(auth()->user()->position ?? '');
        $isTU = str_contains($userPos, 'tata usaha') || str_contains($userPos, 'tu');
    @endphp

    <div class="lg:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around shadow-[0_-2px_10px_rgba(0,0,0,0.05)] z-50">
        @if(auth('siswa')->check())
            {{-- Siswa Menu --}}
            <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.dashboard') ? 'text-emerald-600' : 'text-gray-500' }}">
                <i class="fas fa-home text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Home</span>
            </a>
            <a href="{{ route('siswa.riwayat') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.riwayat') ? 'text-emerald-600' : 'text-gray-500' }}">
                <i class="fas fa-history text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>
            <a href="{{ route('presensi.scan') }}" class="flex flex-col items-center justify-center w-full py-3 relative {{ request()->routeIs('presensi.scan') ? 'text-emerald-600' : 'text-gray-500' }}">
                <div class="absolute -top-4 bg-emerald-600 text-white rounded-full p-3 shadow-lg border-4 border-gray-100">
                    <i class="fas fa-qrcode text-xl"></i>
                </div>
                <span class="text-[10px] font-medium mt-6">Scan</span>
            </a>
            <a href="{{ route('izin.index') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('izin.index') ? 'text-emerald-600' : 'text-gray-500' }}">
                <i class="fas fa-envelope text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Izin</span>
            </a>
            <a href="{{ route('siswa.profil') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.profil') ? 'text-emerald-600' : 'text-gray-500' }}">
                <i class="fas fa-user-circle text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        @elseif($isTU)
            {{-- TU Menu (No Sidebar Trigger on Mobile) --}}
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500' }}">
                <i class="fas fa-th-large text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>
            <a href="{{ route('tu.surat_dinas') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('tu.surat_dinas') ? 'text-indigo-600' : 'text-gray-500' }}">
                <i class="fas fa-plane-departure text-lg mb-1"></i>
                <span class="text-[10px] font-medium">SPD</span>
            </a>
            <a href="{{ route('laporan.rekap_harian') }}" class="flex flex-col items-center justify-center w-full py-3 relative {{ request()->routeIs('laporan.rekap_harian') ? 'text-indigo-600' : 'text-gray-500' }}">
                <div class="absolute -top-4 bg-indigo-600 text-white rounded-full p-3 shadow-lg border-4 border-gray-100">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <span class="text-[10px] font-medium mt-6">Rekap</span>
            </a>
            <a href="{{ route('siswa.index') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.index') ? 'text-indigo-600' : 'text-gray-500' }}">
                <i class="fas fa-users text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Siswa</span>
            </a>
            <a href="{{ route('profil') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('profil') ? 'text-indigo-600' : 'text-gray-500' }}">
                <i class="fas fa-user-circle text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        @else
            {{-- Guru / Admin Menu --}}
            @php
                $loginRole = session('login_role', 'guru');
                $btnColor = 'blue';
                if ($loginRole === 'piket') $btnColor = 'orange';
                elseif ($loginRole === 'admin') $btnColor = 'purple';
                elseif (str_contains(strtolower(auth()->user()->position ?? ''), 'kepala sekolah')) $btnColor = 'zinc';
            @endphp
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('dashboard') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                <i class="fas fa-th-large text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>

            @if($loginRole === 'piket')
                <a href="{{ route('izin.guru') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('izin.guru') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                    <i class="fas fa-file-signature text-lg mb-1"></i>
                    <span class="text-[10px] font-medium">Izin</span>
                </a>
            @elseif($loginRole === 'admin' || $btnColor === 'zinc')
                <a href="{{ route('laporan.index') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('laporan.index') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                    <i class="fas fa-chart-line text-lg mb-1"></i>
                    <span class="text-[10px] font-medium">Laporan</span>
                </a>
            @else
                <a href="{{ route('guru.jurnal.index') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('guru.jurnal.index') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                    <i class="fas fa-book text-lg mb-1"></i>
                    <span class="text-[10px] font-medium">Jurnal</span>
                </a>
            @endif

            <a href="{{ route('guru.qr.status.index') }}" class="flex flex-col items-center justify-center w-full py-3 relative {{ request()->routeIs('guru.qr.status.index') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                <div class="absolute -top-4 bg-{{ $btnColor }}-600 text-white rounded-full p-3 shadow-lg border-4 border-gray-100">
                    <i class="fas fa-clipboard-check text-xl"></i>
                </div>
                <span class="text-[10px] font-medium mt-6">Status</span>
            </a>

            @if($loginRole === 'piket')
                <a href="{{ route('laporan.index') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('laporan.index') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                    <i class="fas fa-chart-pie text-lg mb-1"></i>
                    <span class="text-[10px] font-medium">Laporan</span>
                </a>
            @elseif($loginRole === 'admin' || $btnColor === 'zinc')
                <a href="{{ route('siswa.index') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.index') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                    <i class="fas fa-users text-lg mb-1"></i>
                    <span class="text-[10px] font-medium">Siswa</span>
                </a>
            @else
                <a href="{{ route('guru.catatan.index') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('guru.catatan.index') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                    <i class="fas fa-sticky-note text-lg mb-1"></i>
                    <span class="text-[10px] font-medium">Catatan</span>
                </a>
            @endif

            <a href="{{ route('profil') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('profil') ? 'text-'.$btnColor.'-600' : 'text-gray-500' }}">
                <i class="fas fa-user-circle text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        @endif
    </div>

    <style>
        @media (max-width: 1024px) {
            main.flex-1 { padding-bottom: 5rem !important; }
        }
    </style>
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
            const sidebar = document.getElementById('main-sidebar-scroll');
            if (sidebar) {
                const role = '{{ $currentRole }}';
                const scrollKey = 'sidebar-scroll-' + role;
                
                // Restore
                const savedScroll = localStorage.getItem(scrollKey);
                if (savedScroll) {
                    sidebar.scrollTop = parseInt(savedScroll);
                }

                // Save
                window.addEventListener('beforeunload', function() {
                    localStorage.setItem(scrollKey, sidebar.scrollTop);
                });
            }
        });
    </script>
    @stack('modals')
    @stack('scripts')
</body>
</html>
