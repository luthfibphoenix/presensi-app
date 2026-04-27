<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Portal Ortu - SMKN 7 Purworejo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary: #0d9488;
            --primary-light: #f0fdfa;
            --surface: #ffffff;
            --background: #f8fafc;
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: var(--background);
            -webkit-tap-highlight-color: transparent;
        }
        
        [x-cloak] { display: none !important; }
        
        .safe-bottom { padding-bottom: calc(env(safe-area-inset-bottom) + 1.5rem); }
        .safe-top { padding-top: env(safe-area-inset-top); }

        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .nav-active-pill {
            position: absolute;
            height: 40px;
            background: var(--primary);
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }

        .card-neo {
            background: white;
            border: 1px solid rgba(13, 148, 136, 0.05);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        }

        /* Hide scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        @keyframes slideInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up { animation: slideInUp 0.4s ease-out forwards; }
    </style>
</head>
<body class="antialiased text-slate-800 select-none" x-data="{ userMenuOpen: false }">
    
    <!-- Top Navbar -->
    <header class="fixed top-0 left-0 right-0 z-[60] glass-header border-b border-slate-100 safe-top">
        <div class="max-w-[1200px] mx-auto px-5 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-teal-100 rotate-3">
                    <i class="fas fa-shield-heart text-sm"></i>
                </div>
                <div>
                    <span class="text-slate-900 font-black text-sm tracking-tight uppercase block leading-none">Smart<span class="text-teal-600">Ortu</span></span>
                    <span class="text-slate-400 font-bold text-[8px] uppercase tracking-widest mt-1 block">SMKN 7 Purworejo</span>
                </div>
            </div>

            <!-- Profile Circle -->
            <button @click="userMenuOpen = !userMenuOpen" class="relative group">
                <div class="w-10 h-10 rounded-2xl border-2 border-teal-50 overflow-hidden shadow-sm group-active:scale-95 transition-all">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('orangtua')->user()->nama) }}&background=0d9488&color=fff&bold=true" alt="User" class="w-full h-full object-cover">
                </div>
            </button>
        </div>
    </header>

    <!-- User Modal Overlay (Mobile Friendly) -->
    <div x-show="userMenuOpen" x-cloak 
         class="fixed inset-0 z-[100] flex items-end justify-center p-4 sm:items-center">
        <div x-show="userMenuOpen" @click="userMenuOpen = false" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div x-show="userMenuOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="translate-y-full sm:translate-y-0 sm:scale-95" x-transition:enter-end="translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="translate-y-0 sm:scale-100" x-transition:leave-end="translate-y-full sm:translate-y-0 sm:scale-95"
             class="relative w-full max-w-sm bg-white rounded-[2.5rem] shadow-2xl overflow-hidden animate-slide-up">
            <div class="p-8 text-center">
                <div class="w-20 h-20 mx-auto rounded-[2rem] border-4 border-teal-50 overflow-hidden mb-4 shadow-xl">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('orangtua')->user()->nama) }}&background=0d9488&color=fff&bold=true" class="w-full h-full">
                </div>
                <h3 class="text-lg font-black text-slate-900 leading-tight">{{ auth('orangtua')->user()->nama }}</h3>
                <p class="text-[10px] font-bold text-teal-500 uppercase tracking-widest mt-1">{{ auth('orangtua')->user()->hubungan }} Siswa</p>
                
                <div class="grid grid-cols-1 gap-3 mt-8">
                    <a href="{{ route('ortu.profil') }}" class="flex items-center justify-center gap-3 w-full bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-600 font-bold py-4 rounded-2xl transition-all">
                        <i class="fas fa-user-gear"></i> Pengaturan Profil
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-3 w-full bg-rose-50 hover:bg-rose-100 text-rose-500 font-bold py-4 rounded-2xl transition-all">
                            <i class="fas fa-power-off"></i> Keluar Aplikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="pt-20 min-h-screen pb-32">
        <!-- Decoration Background -->
        <div class="fixed top-0 left-0 right-0 h-64 bg-teal-600 -z-10 rounded-b-[3rem] shadow-2xl shadow-teal-100/50"></div>
        
        <main class="max-w-[1200px] mx-auto">
            @yield('content')
        </main>
    </div>

    <!-- Floating Mobile Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 z-50 md:hidden bg-white/80 backdrop-blur-2xl border-t border-slate-100 safe-bottom shadow-[0_-10px_25px_-5px_rgba(0,0,0,0.05)]">
        <nav class="max-w-md mx-auto px-6 h-16 flex items-center justify-between relative">
            @php
                $isHome = request()->routeIs('ortu.dashboard');
                $isHistory = request()->routeIs('ortu.kehadiran');
                $isIzin = request()->routeIs('ortu.izin');
                
                $pillPos = $isHome ? 'left-[10%]' : ($isHistory ? 'left-[41.5%]' : 'left-[73%]');
            @endphp
            
            <!-- Floating Indicator Pill -->
            <div class="absolute h-1 w-8 bg-teal-500 rounded-full top-0 transition-all duration-500 ease-out {{ $pillPos }}"></div>

            <a href="{{ route('ortu.dashboard') }}" class="flex flex-col items-center gap-1 flex-1 py-2 transition-all {{ $isHome ? 'text-teal-600 scale-110' : 'text-slate-400' }}">
                <div class="relative">
                    <i class="fas fa-grid-2 text-lg"></i>
                    @if($isHome) <div class="absolute -top-1 -right-1 w-1.5 h-1.5 bg-teal-500 rounded-full animate-pulse"></div> @endif
                </div>
                <span class="text-[8px] font-black uppercase tracking-tighter">Beranda</span>
            </a>

            <a href="{{ route('ortu.kehadiran') }}" class="flex flex-col items-center gap-1 flex-1 py-2 transition-all {{ $isHistory ? 'text-teal-600 scale-110' : 'text-slate-400' }}">
                <i class="fas fa-calendar-days text-lg"></i>
                <span class="text-[8px] font-black uppercase tracking-tighter">Histori</span>
            </a>

            <a href="{{ route('ortu.izin') }}" class="flex flex-col items-center gap-1 flex-1 py-2 transition-all {{ $isIzin ? 'text-teal-600 scale-110' : 'text-slate-400' }}">
                <i class="fas fa-file-signature text-lg"></i>
                <span class="text-[8px] font-black uppercase tracking-tighter">Izin</span>
            </a>
        </nav>
    </div>

    @stack('scripts')
</body>
</html>
