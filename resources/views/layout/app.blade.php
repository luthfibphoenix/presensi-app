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
    <div class="min-h-screen">
        
        <!-- Sidebar Overlay (mobile) -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-40 lg:hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        @php
            $currentRole = auth('siswa')->check() ? 'siswa' : session('login_role', 'guru');
        @endphp
        <x-sidebar :role="$currentRole" />

        <!-- Main Content -->
        <div class="lg:ml-64 flex flex-col min-w-0 bg-[#f3f4f6] min-h-screen">
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 z-40 relative flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-600">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-lg font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-gray-900 leading-none mb-1">{{ auth()->user()->fullname ?? auth()->user()->nama }}</p>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">{{ auth()->user()->position ?? 'Siswa' }}</p>
                    </div>
                    @php
                        $userPhoto = auth()->user()->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->fullname ?? auth()->user()->nama) . '&background=3B82F6&color=fff&bold=true';
                    @endphp
                    <img src="{{ $userPhoto }}" 
                         alt="User" 
                         class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                </div>
            </header>

            <!-- Content Body -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>>
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

    @stack('scripts')
</body>
</html>
