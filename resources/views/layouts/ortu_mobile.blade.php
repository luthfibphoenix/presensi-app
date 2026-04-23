<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Portal Orang Tua - SMKN 7 Purworejo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f0fdfa; /* Very light teal tint */
        }
        [x-cloak] { display: none !important; }
        
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom); }

        @media (min-width: 768px) {
            .desktop-container {
                max-width: 1200px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body class="antialiased text-slate-800" x-data="{ userMenuOpen: false }">
    
    <!-- Top Navbar (Visible on Desktop, simplified on Mobile) -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-teal-100 z-[60] shadow-sm">
        <div class="max-w-[1200px] mx-auto px-4 md:px-6 h-full flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-teal-100">
                    <i class="fas fa-user-shield text-sm"></i>
                </div>
                <div class="leading-tight">
                    <span class="text-slate-900 font-black text-sm tracking-tight uppercase block">Presensi<span class="text-teal-600">Ortu</span></span>
                    <span class="hidden md:block text-slate-400 font-bold text-[9px] uppercase tracking-widest">SMKN 7 Purworejo</span>
                </div>
            </div>

            <!-- Desktop Horizontal Navigation -->
            <nav class="hidden md:flex items-center gap-1">
                <a href="{{ route('ortu.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-bold {{ request()->routeIs('ortu.dashboard') ? 'bg-teal-50 text-teal-600' : 'text-slate-500 hover:bg-slate-50' }} transition-all">Home</a>
                <a href="{{ route('ortu.kehadiran') }}" class="px-4 py-2 rounded-xl text-sm font-bold {{ request()->routeIs('ortu.kehadiran') ? 'bg-teal-50 text-teal-600' : 'text-slate-500 hover:bg-slate-50' }} transition-all">Kehadiran</a>
                <a href="{{ route('ortu.izin') }}" class="px-4 py-2 rounded-xl text-sm font-bold {{ request()->routeIs('ortu.izin') ? 'bg-teal-50 text-teal-600' : 'text-slate-500 hover:bg-slate-50' }} transition-all">Izin</a>
            </nav>

            <!-- User Menu -->
            <div class="relative">
                <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" class="flex items-center gap-3 focus:outline-none">
                    <div class="text-right hidden md:block">
                        <p class="text-xs font-black text-slate-800 mb-0.5">{{ auth('orangtua')->user()->nama }}</p>
                        <p class="text-[8px] font-bold text-teal-400 uppercase tracking-tighter">{{ auth('orangtua')->user()->hubungan }} Siswa</p>
                    </div>
                    <div class="w-10 h-10 rounded-full border-2 border-teal-100 overflow-hidden shadow-sm hover:border-teal-500 transition-colors">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('orangtua')->user()->nama) }}&background=0d9488&color=fff&bold=true" alt="User">
                    </div>
                </button>

                <!-- Dropdown -->
                <div x-show="userMenuOpen" x-cloak x-transition class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-2xl border border-teal-50 py-2 z-50 overflow-hidden">
                    <div class="px-5 py-3 border-b border-teal-50 md:hidden">
                        <p class="text-xs font-black text-slate-800 truncate">{{ auth('orangtua')->user()->nama }}</p>
                        <p class="text-[8px] font-bold text-teal-500 uppercase">{{ auth('orangtua')->user()->hubungan }} Siswa</p>
                    </div>
                    <a href="{{ route('ortu.profil') }}" class="w-full flex items-center gap-3 px-5 py-3 text-sm text-slate-600 hover:bg-teal-50 transition font-bold {{ request()->routeIs('ortu.profil') ? 'text-teal-600 bg-teal-50' : '' }}">
                        <i class="fas fa-user-circle"></i> Profil Saya
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-sm text-rose-500 hover:bg-rose-50 transition font-bold border-t border-slate-50">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Content Wrapper -->
    <div class="pt-16 min-h-screen">
        <!-- Compact Header Background (Teal) -->
        <div class="bg-teal-600 h-32 md:h-40 w-full relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        </div>

        <main class="max-w-[1200px] mx-auto px-0 md:px-6 -mt-16 md:-mt-20 pb-28 md:pb-12 relative z-10">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Bottom Navigation (Hidden on Desktop) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-xl border-t border-teal-100 z-50 safe-bottom">
        <div class="flex justify-around items-center h-20 px-2">
            <a href="{{ route('ortu.dashboard') }}" class="flex flex-col items-center gap-1.5 flex-1 py-3 {{ request()->routeIs('ortu.dashboard') ? 'text-teal-600' : 'text-slate-400' }}">
                <i class="fas fa-home text-lg"></i>
                <span class="text-[9px] font-black uppercase tracking-tighter">Home</span>
            </a>
            <a href="{{ route('ortu.kehadiran') }}" class="flex flex-col items-center gap-1.5 flex-1 py-3 {{ request()->routeIs('ortu.kehadiran') ? 'text-teal-600' : 'text-slate-400' }}">
                <i class="fas fa-calendar-alt text-lg"></i>
                <span class="text-[9px] font-black uppercase tracking-tighter">Kehadiran</span>
            </a>
            <a href="{{ route('ortu.izin') }}" class="flex flex-col items-center gap-1.5 flex-1 py-3 {{ request()->routeIs('ortu.izin') ? 'text-teal-600' : 'text-slate-400' }}">
                <i class="fas fa-file-invoice text-lg"></i>
                <span class="text-[9px] font-black uppercase tracking-tighter">Izin</span>
            </a>
        </div>
    </nav>

    @stack('scripts')
</body>
</html>
