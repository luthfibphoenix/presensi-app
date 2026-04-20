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
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal" 
      x-data="{ 
        activeRole: localStorage.getItem('activeRole') || '{{ auth('web')->check() ? 'guru' : (auth('siswa')->check() ? 'siswa' : 'none') }}'
      }"
      x-init="$watch('activeRole', value => localStorage.setItem('activeRole', value))">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <div class="w-64 bg-blue-900 text-white flex flex-col transition-all duration-300">
            <div class="flex items-center justify-center h-16 bg-blue-950 flex-shrink-0">
                <span class="text-white font-bold uppercase text-xl">Presensi App</span>
            </div>
            
            @auth('web')
            <div x-show="activeRole === 'guru'" class="flex flex-col items-center justify-center py-6 px-4 border-b border-blue-800 bg-blue-900/50 flex-shrink-0">
                @php
                    $user = Auth::user();
                    $photoUrl = $user->photo_url;
                    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname ?? 'User') . '&background=3B82F6&color=fff&bold=true&size=128';
                @endphp
                <img src="{{ $photoUrl }}" 
                     alt="Profile Photo" 
                     onerror="this.onerror=null; this.src='{{ $fallbackUrl }}';"
                     class="w-20 h-20 rounded-full object-cover border-2 border-blue-400 mb-3 shadow-md">
                <h3 class="text-white font-bold text-center text-sm leading-tight">{{ $user->fullname }}</h3>
                <span class="mt-2 px-2 py-0.5 bg-blue-500/30 text-blue-200 text-[10px] font-bold uppercase rounded-full border border-blue-400/30">
                    {{ $user->position }}
                </span>
            </div>
            @endauth

            @auth('siswa')
            <div x-show="activeRole === 'siswa'" class="flex flex-col items-center justify-center py-6 px-4 border-b border-emerald-800 bg-emerald-900/30 flex-shrink-0">
                @php
                    $siswa = auth('siswa')->user();
                    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama ?? 'Siswa') . '&background=10B981&color=fff&bold=true&size=128';
                @endphp
                <div class="relative">
                    <img src="{{ $fallbackUrl }}" 
                         alt="Siswa Photo" 
                         class="w-20 h-20 rounded-full object-cover border-2 border-emerald-400 mb-3 shadow-md">
                    <div class="absolute bottom-3 right-0 w-5 h-5 bg-emerald-500 border-2 border-emerald-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-[8px] text-white"></i>
                    </div>
                </div>
                <h3 class="text-white font-bold text-center text-sm leading-tight">{{ $siswa->nama }}</h3>
                <span class="mt-2 px-2 py-0.5 bg-emerald-500/30 text-emerald-200 text-[10px] font-bold uppercase rounded-full border border-emerald-400/30">
                    Siswa · {{ $siswa->kelas->nama_kelas ?? '-' }}
                </span>
            </div>
            @endauth

            <div class="overflow-y-auto overflow-x-hidden flex-grow">
                <ul class="flex flex-col py-4 space-y-1">                    @auth('web')
                    <template x-if="activeRole === 'guru'">
                        <div>
                            <li class="px-5 mb-2">
                                <div class="flex flex-row items-center h-8">
                                    <div class="text-[10px] font-bold tracking-widest text-blue-300 uppercase opacity-60">Utama</div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('dashboard') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-th-large"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Beranda</span>
                                </a>
                            </li>
                            
                            @if(in_array(auth()->user()->position, ['Administrator', 'Guru BK']))
                            <li class="px-5 mt-4 mb-2">
                                <div class="flex flex-row items-center h-8">
                                    <div class="text-[10px] font-bold tracking-widest text-blue-300 uppercase opacity-60">Laporan & Izin</div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('laporan.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('laporan.index') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-file-invoice"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Rekap Presensi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('izin.guru') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('izin.guru') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-user-check"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Approval Izin</span>
                                </a>
                            </li>
                            @endif

                            @php
                                $isGuru = in_array(auth()->user()->position, ['Administrator', 'Guru', 'Wali Kelas']) ||
                                          strpos(auth()->user()->position, 'Guru') !== false ||
                                          strpos(auth()->user()->position, 'Waka') !== false;
                            @endphp
                            @if($isGuru)
                            <li class="px-5 mt-4 mb-2">
                                <div class="flex flex-row items-center h-8">
                                    <div class="text-[10px] font-bold tracking-widest text-blue-300 uppercase opacity-60">Layanan Presensi</div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('jadwal.hari.ini') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('jadwal.hari.ini') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-calendar-day"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Jadwal Hari Ini</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('jadwal.semua') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('jadwal.semua') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-calendar-week"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Semua Jadwal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('guru.qr.status.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('guru.qr.status*') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-clipboard-check"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Status Kehadiran</span>
                                </a>
                            </li>
                            @endif
                        </div>
                    </template>
                    @endauth

                    @auth('siswa')
                    <template x-if="activeRole === 'siswa'">
                        <div>
                            <li class="px-5 mb-2">
                                <div class="flex flex-row items-center h-8">
                                    <div class="text-[10px] font-bold tracking-widest text-emerald-300 uppercase opacity-60">Utama</div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('siswa.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-th-large"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Beranda</span>
                                </a>
                            </li>

                            <li class="px-5 mt-4 mb-2">
                                <div class="flex flex-row items-center h-8">
                                    <div class="text-[10px] font-bold tracking-widest text-emerald-300 uppercase opacity-60">Layanan Absensi</div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('presensi.scan') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('presensi.scan') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-qrcode"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Scan QR Absen</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('siswa.riwayat') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('siswa.riwayat') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-history"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Riwayat Kehadiran</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('izin.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('izin.index') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-file-signature"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Pengajuan Izin</span>
                                </a>
                            </li>

                            <li class="px-5 mt-4 mb-2">
                                <div class="flex flex-row items-center h-8">
                                    <div class="text-[10px] font-bold tracking-widest text-emerald-300 uppercase opacity-60">Akun</div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('siswa.profil') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white border-l-4 {{ request()->routeIs('siswa.profil') ? 'bg-blue-800 border-blue-500' : 'border-transparent hover:border-blue-500' }} pr-6">
                                    <span class="inline-flex justify-center items-center ml-4"><i class="fas fa-user-cog"></i></span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Profil Saya</span>
                                </a>
                            </li>
                        </div>
                    </template>
                    @endauth
                </ul>
            </div>
            
        </div>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <div class="text-xl font-semibold text-gray-700">@yield('title', 'Dashboard')</div>
                    
                    {{-- Role Switcher --}}
                    @if(auth('web')->check() && auth('siswa')->check())
                    <div class="hidden md:flex items-center bg-gray-100 rounded-lg p-1 border border-gray-200">
                        <button @click="activeRole = 'guru'" 
                                :class="activeRole === 'guru' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-200 flex items-center gap-1.5">
                            <i class="fas fa-chalkboard-teacher"></i> Guru
                        </button>
                        <button @click="activeRole = 'siswa'" 
                                :class="activeRole === 'siswa' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-200 flex items-center gap-1.5">
                            <i class="fas fa-user-graduate"></i> Siswa
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Navbar Right: Profile Dropdown -->
                <div class="flex items-center gap-3">
                    {{-- Dropdown: GURU/ADMIN --}}
                    @auth('web')
                    <div x-show="activeRole === 'guru'" class="relative" x-data="{ open: false }">
                        @php
                            $user = Auth::user();
                            $navPhotoUrl = $user->photo_url;
                            $navFallback = 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname ?? 'User') . '&background=3B82F6&color=fff&bold=true&size=64';
                        @endphp
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group px-2 py-1 rounded-lg hover:bg-gray-50 transition">
                            <div class="hidden md:flex flex-col items-end mr-1">
                                <span class="text-sm font-bold text-gray-800 leading-tight">{{ $user->fullname }}</span>
                                <span class="text-[10px] font-medium text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded uppercase tracking-wider mt-0.5">{{ $user->position }}</span>
                            </div>
                            <img src="{{ $navPhotoUrl }}"
                                 alt="Avatar"
                                 onerror="this.onerror=null; this.src='{{ $navFallback }}';"
                                 class="w-9 h-9 rounded-full object-cover border-2 border-blue-200 group-hover:border-blue-400 transition">
                            <i class="fas fa-chevron-down text-gray-400 text-xs ml-1"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false"
                             x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50 rounded-t-xl">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $user->fullname }}</p>
                                <p class="text-xs text-blue-600 font-medium truncate mt-0.5">{{ $user->position }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('profil') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition">
                                    <i class="fas fa-user-circle w-4 text-gray-400"></i> Profil Saya
                                </a>
                                @if(auth('siswa')->check())
                                <button @click="activeRole = 'siswa'; open = false" class="md:hidden w-full flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition text-left">
                                    <i class="fas fa-exchange-alt w-4 text-gray-400"></i> Switch ke Siswa
                                </button>
                                @endif
                            </div>
                            <div class="border-t border-gray-100 py-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition text-left">
                                        <i class="fas fa-sign-out-alt w-4"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth

                    {{-- Dropdown: SISWA --}}
                    @auth('siswa')
                    <div x-show="activeRole === 'siswa'" class="relative" x-data="{ open: false }">
                        @php
                            $siswaNav = auth('siswa')->user();
                            $navFallback = 'https://ui-avatars.com/api/?name=' . urlencode($siswaNav->nama ?? 'Siswa') . '&background=10B981&color=fff&bold=true&size=64';
                        @endphp
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group px-2 py-1 rounded-lg hover:bg-gray-50 transition">
                            <div class="hidden md:flex flex-col items-end mr-1">
                                <span class="text-sm font-bold text-gray-800 leading-tight">{{ $siswaNav->nama }}</span>
                                <span class="text-[10px] font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase tracking-wider mt-0.5">Siswa</span>
                            </div>
                            <img src="{{ $navFallback }}"
                                 alt="Avatar"
                                 class="w-9 h-9 rounded-full object-cover border-2 border-emerald-200 group-hover:border-emerald-400 transition">
                            <i class="fas fa-chevron-down text-gray-400 text-xs ml-1"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false"
                             x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                            <div class="px-4 py-3 border-b border-gray-100 bg-emerald-50/50 rounded-t-xl">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $siswaNav->nama }}</p>
                                <p class="text-xs text-emerald-600 font-medium truncate mt-0.5">Siswa · {{ $siswaNav->kelas->nama_kelas ?? '-' }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('siswa.profil') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 transition">
                                    <i class="fas fa-id-card w-4 text-emerald-500"></i> Profil Saya
                                </a>
                                @if(auth('web')->check())
                                <button @click="activeRole = 'guru'; open = false" class="md:hidden w-full flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 transition text-left">
                                    <i class="fas fa-exchange-alt w-4 text-emerald-400"></i> Switch ke Guru
                                </button>
                                @endif
                            </div>
                            <div class="border-t border-gray-100 py-1">
                                <form action="{{ route('siswa.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition text-left">
                                        <i class="fas fa-sign-out-alt w-4"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Content Body -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if (session('info'))
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded shadow-sm">
                        {{ session('info') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Bottom Navigation (Siswa Only) -->
    @auth('siswa')
    <div x-show="activeRole === 'siswa'" class="md:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around shadow-[0_-2px_10px_rgba(0,0,0,0.05)] z-50">
        <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.dashboard') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">
            <i class="fas fa-home text-lg mb-1"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="{{ route('siswa.riwayat') }}" class="flex flex-col items-center justify-center w-full py-3 {{ request()->routeIs('siswa.riwayat') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">
            <i class="fas fa-history text-lg mb-1"></i>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        <a href="{{ route('presensi.scan') }}" class="flex flex-col items-center justify-center w-full py-3 relative {{ request()->routeIs('presensi.scan') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">
            <!-- Special styling for Scan button to make it pop -->
            <div class="absolute -top-4 bg-blue-600 text-white rounded-full p-3 shadow-lg border-4 border-gray-100 {{ request()->routeIs('presensi.scan') ? 'bg-blue-700' : '' }}">
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
    
    <!-- Add padding to bottom of main content to accommodate bottom nav -->
    <style>
        @media (max-width: 768px) {
            main.flex-1 { padding-bottom: 5rem !important; }
            .w-64.bg-blue-900 { display: none; }
        }
    </style>
    @endauth

    @stack('scripts')
</body>
</html>
