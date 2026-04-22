<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi SMKN7</title>
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
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal" 
      x-data="{ 
        activeRole: localStorage.getItem('activeRole') || '{{ auth('web')->check() ? 'guru' : (auth('siswa')->check() ? 'siswa' : 'none') }}',
        sidebarOpen: false
      }"
      x-init="$watch('activeRole', value => localStorage.setItem('activeRole', value))">
    <div class="min-h-screen bg-gray-50 flex">
        
        <!-- Sidebar -->
        @php
            $currentRole = auth('siswa')->check() ? 'siswa' : session('login_role', 'guru');
        @endphp
        <x-sidebar :role="$currentRole" />

        <!-- Main Content Wrapper -->
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen lg:h-screen relative overflow-y-auto lg:overflow-hidden no-scrollbar">
            <!-- Fixed Top Navbar -->
            <header class="h-16 bg-white shadow-sm border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0 z-40">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-lg font-bold text-gray-800 tracking-tight">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-4 relative" id="userMenuContainer">
                    <button id="userMenuBtn" class="flex items-center gap-4 focus:outline-none group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-900 leading-none mb-1 group-hover:text-blue-600 transition">{{ auth()->user()->fullname ?? auth()->user()->nama }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ auth()->user()->position ?? 'Siswa' }}</p>
                        </div>
                        @php
                            $userPhoto = auth()->user()->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->fullname ?? auth()->user()->nama) . '&background=f3f4f6&color=6b7280&bold=true';
                        @endphp
                        <img src="{{ $userPhoto }}" 
                             alt="User" 
                             class="w-10 h-10 rounded-full border-2 border-gray-100 object-cover shadow-sm group-hover:border-blue-200 transition">
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="hidden absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden py-1 animate-fade-in-up">
                        <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50">
                            <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Pengguna</p>
                            <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->fullname ?? auth()->user()->nama }}</p>
                        </div>
                        <a href="{{ auth('siswa')->check() ? route('siswa.profil') : route('profil') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                            <i class="fas fa-user-circle opacity-40"></i> Profil Saya
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
                        <div class="border-t border-gray-50 py-1">
                            <form action="{{ route('dashboard.end_session') }}" method="POST" onsubmit="return confirm('Akhiri sesi kelas sekarang? Siswa yang belum absen akan otomatis dicatat Alfa.')">
                                @csrf
                                <input type="hidden" name="session_id" value="{{ $activeSess->id }}">
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-sm text-red-600 hover:bg-red-50 transition text-left font-bold">
                                    <i class="fas fa-power-off"></i> Akhiri Kelas
                                </button>
                            </form>
                        </div>
                        @endif

                        <div class="border-t border-gray-50 py-1">
                            <form action="{{ auth('siswa')->check() ? route('siswa.logout') : route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-sm text-gray-400 hover:bg-gray-50 transition text-left font-semibold">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <main class="flex-1 overflow-hidden p-6">
                @if (session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-3 mb-4 rounded-xl shadow-sm animate-fade-in-down">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle"></i>
                            <span class="font-medium text-xs">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Bottom Navigation (Siswa Only) -->
    @auth('siswa')
    <div x-show="activeRole === 'siswa'" class="lg:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around shadow-[0_-2px_10px_rgba(0,0,0,0.05)] z-50">
        <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.dashboard') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">
            <i class="fas fa-home text-lg mb-1"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="{{ route('siswa.riwayat') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.riwayat') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">
            <i class="fas fa-history text-lg mb-1"></i>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        <a href="{{ route('presensi.scan') }}" class="flex flex-col items-center justify-center w-full py-3 relative {{ request()->routeIs('presensi.scan') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">
            <div class="absolute -top-4 bg-blue-600 text-white rounded-full p-3 shadow-lg border-4 border-gray-100">
                <i class="fas fa-camera text-xl"></i>
            </div>
            <span class="text-[10px] font-medium mt-6">Scan</span>
        </a>
        <a href="{{ route('izin.index') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('izin.index') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">
            <i class="fas fa-envelope text-lg mb-1"></i>
            <span class="text-[10px] font-medium">Izin</span>
        </a>
        <a href="{{ route('siswa.profil') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.profil') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">
            <i class="fas fa-user-circle text-lg mb-1"></i>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>

    <style>
        @media (max-width: 1024px) {
            main.flex-1 { padding-bottom: 5rem !important; }
        }
    </style>
    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            const sidebar = document.getElementById('main-sidebar');
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
    @stack('scripts')
</body>
</html>
