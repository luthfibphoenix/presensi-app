<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#0d9488">
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

        /* Active Mobile Nav Effect */
        .mobile-nav-item.active {
            transform: translateY(-8px);
        }
        .mobile-nav-item.active i {
            transform: scale(1.25);
            filter: drop-shadow(0 4px 10px rgba(13, 148, 136, 0.3));
        }
        .mobile-nav-item.active span {
            transform: scale(1.1);
            font-weight: 800;
        }
        
        .mobile-nav-container {
            padding-bottom: calc(1rem + env(safe-area-inset-bottom)) !important;
        }
    </style>
</head>
<body class="antialiased text-slate-800 select-none" x-data="{ userMenuOpen: false }">
    <!-- Top Progress Loader -->
    <div id="page-loader" class="fixed top-0 left-0 z-[9999] h-[2px] bg-cyan-600 w-0 transition-all duration-300 ease-out"></div>
    
    <!-- Top Navbar -->
    <header class="flex items-center justify-between px-4 py-3 bg-white border-b border-gray-100 fixed top-0 left-0 right-0 z-50 safe-top">
        <div class="flex items-center gap-3">
            <button @click="userMenuOpen = !userMenuOpen" class="p-1">
                <i class="fas fa-bars text-gray-500"></i>
            </button>
            <h1 class="text-base font-semibold text-gray-800">Portal Orang Tua</h1>
        </div>
        <!-- Avatar atau inisial -->
        <div class="w-9 h-9 rounded-full overflow-hidden bg-cyan-100 flex items-center justify-center text-sm font-semibold text-cyan-700">
            {{ collect(explode(' ', $siswa->nama))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}
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
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=0d9488&color=fff&bold=true" class="w-full h-full">
                </div>
                <h3 class="text-lg font-black text-slate-900 leading-tight">Orang Tua {{ $siswa->nama }}</h3>
                <p class="text-[10px] font-bold text-teal-500 uppercase tracking-widest mt-1">Wali Murid Resmi</p>
                
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
    <div class="pt-16 min-h-[100dvh] pb-24 bg-gray-50">
        <main class="max-w-[1200px] mx-auto">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-100 shadow-[0_-1px_12px_rgba(0,0,0,0.06)]"
         style="padding-bottom:env(safe-area-inset-bottom)">
        <div class="flex items-stretch h-16">
            @foreach([
                ['label' => 'Beranda', 'route' => 'ortu.dashboard', 'icon' => 'fas fa-house-chimney-window'],
                ['label' => 'Histori', 'route' => 'ortu.kehadiran', 'icon' => 'fas fa-clock-rotate-left'],
                ['label' => 'Izin', 'route' => 'ortu.izin', 'icon' => 'fas fa-envelope-open-text'],
                ['label' => 'Profil', 'route' => 'ortu.profil', 'icon' => 'fas fa-user-circle'],
            ] as $item)
                <a href="{{ route($item['route']) }}" 
                   class="flex flex-col items-center justify-center flex-1 pt-1 transition-colors duration-200">
                    <span class="w-8 h-1 rounded-full mb-1 {{ request()->routeIs($item['route']) ? 'bg-cyan-500' : 'bg-transparent' }}"></span>
                    <i class="{{ $item['icon'] }} text-[20px] {{ request()->routeIs($item['route']) ? 'text-cyan-600' : 'text-gray-400' }}"></i>
                    <span class="text-[11px] mt-0.5 {{ request()->routeIs($item['route']) ? 'font-semibold text-cyan-600' : 'font-normal text-gray-400' }}">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
                if (loader) {
                    loader.style.width = '100%';
                    document.body.classList.add('page-leaving');
                }
            });

            window.addEventListener('pageshow', (event) => {
                if (event.persisted) {
                    document.body.classList.remove('page-leaving');
                    if (loader) {
                        loader.style.width = '0%';
                        loader.style.opacity = '1';
                        setTimeout(() => {
                            loader.style.opacity = '0';
                        }, 300);
                    }
                }
            });

            // Ortu Auto-Logout (5 Minutes Inactivity)
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
        });
    </script>
    @stack('scripts')
</body>
</html>
