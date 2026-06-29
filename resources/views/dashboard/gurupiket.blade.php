@extends('layout.app')

@php
    $aksen = 'green-600';
@endphp

@section('title', 'Dashboard Guru Piket')

@section('content')
<div class="space-y-6">
    {{-- Welcome Card (Forest green gradient style with ambient glow orbs) --}}
    <div class="relative overflow-hidden rounded-[2.5rem] p-6 md:p-8 text-white shadow-2xl transition-all duration-300 hover:shadow-green-900/10 animate-slide-up"
         style="background: linear-gradient(135deg, #0B301E, #15803d);">
        <!-- Decorative glowing orbs -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-emerald-400 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-teal-500 rounded-full blur-3xl opacity-15"></div>

        <div class="relative z-10 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-emerald-200">
                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-ping"></span>
                Piket Portal
            </span>
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight">Halo, {{ auth()->user()->fullname ?? auth()->user()->nama }}! 👋</h1>
                <p class="text-xs text-emerald-100/90 font-medium mt-1">
                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }} - Selamat bertugas sebagai Guru Piket hari ini.
                </p>
            </div>
            <div class="flex gap-3 pt-1">
                <a href="{{ route('izin.guru') }}" class="px-5 py-3 bg-white text-emerald-950 text-xs font-black rounded-2xl flex items-center justify-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95">
                    <i class="fas fa-plus-circle text-emerald-600"></i> INPUT IZIN
                </a>
                <a href="{{ route('laporan.rekap_harian') }}" class="px-5 py-3 bg-white/10 border border-white/20 text-white text-xs font-black rounded-2xl flex items-center justify-center gap-1.5 backdrop-blur-sm transition-all hover:bg-white/25 active:scale-95">
                    <i class="fas fa-file-invoice text-emerald-300"></i> REKAP HARIAN
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid (Hadir, Izin, Sakit, Alfa) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Hadir Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Hadir</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $stats['hadir'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm border border-emerald-100">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
            <div class="flex items-center gap-1 mt-4 text-[10px] text-emerald-600 font-bold">
                <i class="fas fa-caret-up"></i>
                <span>+12 dari kemarin</span>
            </div>
        </div>

        <!-- Izin Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Izin</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $stats['izin'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-sm border border-amber-100">
                    <i class="fas fa-file-invoice"></i>
                </div>
            </div>
            <div class="flex items-center gap-1 mt-4 text-[10px] text-slate-400 font-bold">
                <i class="fas fa-minus text-[8px]"></i>
                <span>sama seperti kemarin</span>
            </div>
        </div>

        <!-- Sakit Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Sakit</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $stats['sakit'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-sm border border-blue-100">
                    <i class="fas fa-hand-holding-medical"></i>
                </div>
            </div>
            <div class="flex items-center gap-1 mt-4 text-[10px] text-rose-500 font-bold">
                <i class="fas fa-caret-down"></i>
                <span>-2 dari kemarin</span>
            </div>
        </div>

        <!-- Alfa Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Alfa</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $stats['alfa'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-sm border border-rose-100">
                    <i class="fas fa-user-times"></i>
                </div>
            </div>
            <div class="flex items-center gap-1 mt-4 text-[10px] text-rose-600 font-bold">
                <i class="fas fa-caret-up"></i>
                <span>+1 dari kemarin</span>
            </div>
        </div>
    </div>

    {{-- Main Panel Split Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <!-- Left Column: Stack of Cards -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Siswa Tidak Hadir Hari Ini -->
            <div class="bg-white rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.01)] border border-slate-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Siswa Tidak Hadir Hari Ini</h3>
                        <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <a href="{{ route('izin.guru') }}" class="px-4 py-2.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-100 text-xs font-black rounded-xl flex items-center gap-1.5 transition-all">
                        <i class="fas fa-plus"></i> Tambah Catatan
                    </a>
                </div>
                
                {{-- Desktop View Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Siswa</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Kelas</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Mapel / Jam</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-center">Status</th>
                                <th class="px-6 py-4 text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($absentStudents as $absent)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 overflow-hidden">
                                            @if(isset($absent->siswa->photo_url) && $absent->siswa->photo_url)
                                                <img src="{{ $absent->siswa->photo_url }}" class="w-full h-full object-cover">
                                            @else
                                                {{ collect(explode(' ', $absent->siswa->nama ?? 'S I'))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-700 text-xs">{{ $absent->siswa->nama ?? 'Siswa Tidak Diketahui' }}</div>
                                            <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">NIS: {{ $absent->siswa->nis ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-500">
                                    {{ $absent->siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-slate-600">{{ $absent->jadwal->mata_pelajaran ?? '-' }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Jam ke-{{ $absent->jadwal->jam_mulai ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $badgeClass = match($absent->status) {
                                            'Alfa' => 'bg-rose-50 text-rose-600 border-rose-100',
                                            'Izin' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'Sakit' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            default => 'bg-slate-50 text-slate-600 border-slate-100'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase border {{ $badgeClass }}">
                                        {{ $absent->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-slate-300 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-50 transition-colors">
                                        <i class="fas fa-ellipsis-h text-sm"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold text-xs italic">
                                    Belum ada catatan ketidakhadiran hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Mobile View Cards --}}
                <div class="md:hidden divide-y divide-slate-50">
                    @forelse($absentStudents as $absent)
                    <div class="p-5 flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="text-sm font-black text-slate-800 leading-tight">{{ $absent->siswa->nama ?? 'Siswa Tidak Diketahui' }}</h4>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">{{ $absent->siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[8px] font-black uppercase italic">JP {{ $absent->jadwal->jam_mulai ?? '-' }}</span>
                                <span class="text-[9px] font-bold text-slate-500 truncate max-w-[120px]">{{ $absent->jadwal->mata_pelajaran ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="shrink-0">
                            @php
                                $badgeClass = match($absent->status) {
                                    'Alfa' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    'Izin' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'Sakit' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    default => 'bg-slate-50 text-slate-600 border-slate-100'
                                };
                            @endphp
                            <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase border {{ $badgeClass }}">
                                {{ $absent->status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Belum ada catatan ketidakhadiran.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- 5 Pengajuan Izin Terakhir -->
            <div class="bg-white rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.01)] border border-slate-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">5 Pengajuan Izin Terakhir</h3>
                        <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase">Portal Persetujuan Izin Siswa</p>
                    </div>
                    <a href="{{ route('izin.guru') }}" class="px-4 py-2.5 bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-100 text-xs font-black rounded-xl flex items-center gap-1.5 transition-all">
                        <i class="fas fa-list-check"></i> Kelola Semua Izin
                    </a>
                </div>
                
                {{-- Desktop View Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Siswa</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Kelas</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Keterangan</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentIzinSubmissions as $izin)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 overflow-hidden">
                                            @if(isset($izin->siswa->photo_url) && $izin->siswa->photo_url)
                                                <img src="{{ $izin->siswa->photo_url }}" class="w-full h-full object-cover">
                                            @else
                                                {{ collect(explode(' ', $izin->siswa->nama ?? 'S I'))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-700 text-xs">{{ $izin->siswa->nama ?? 'Siswa Tidak Diketahui' }}</div>
                                            <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">NIS: {{ $izin->siswa->nis ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-500">
                                    {{ $izin->siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-slate-600">
                                        <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider border 
                                            @if($izin->tipe == 'Sakit') bg-rose-50 text-rose-600 border-rose-100
                                            @elseif($izin->tipe == 'Masuk Telat') bg-orange-50 text-orange-600 border-orange-100
                                            @elseif($izin->tipe == 'Keluar Sekolah') bg-purple-50 text-purple-600 border-purple-100
                                            @else bg-blue-50 text-blue-600 border-blue-100
                                            @endif">
                                            {{ $izin->tipe }}
                                        </span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-bold mt-1 line-clamp-1 italic max-w-[200px]" title="{{ $izin->alasan }}">"{{ $izin->alasan }}"</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $badgeClass = match($izin->status) {
                                            'approve', 'Disetujui' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'reject', 'Ditolak' => 'bg-rose-50 text-rose-600 border-rose-100',
                                            default => 'bg-amber-50 text-amber-600 border-amber-100'
                                        };
                                        $statusLabel = match($izin->status) {
                                            'approve', 'Disetujui' => 'Disetujui',
                                            'reject', 'Ditolak' => 'Ditolak',
                                            default => 'Menunggu'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase border {{ $badgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($izin->bukti)
                                            <a href="{{ asset($izin->bukti) }}" target="_blank" class="p-1.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg hover:bg-blue-100 transition-colors" title="Lihat Bukti">
                                                <i class="fas fa-image text-xs"></i>
                                            </a>
                                        @endif
                                        @if($izin->latitude && $izin->longitude)
                                            <a href="https://www.google.com/maps?q={{ $izin->latitude }},{{ $izin->longitude }}" target="_blank" class="p-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg hover:bg-emerald-100 transition-colors" title="Lihat Lokasi">
                                                <i class="fas fa-location-dot text-xs"></i>
                                            </a>
                                        @endif
                                        
                                        @if($izin->status == 'pending')
                                            <form action="{{ route('izin.approve', $izin->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors flex items-center justify-center" title="Setujui">
                                                    <i class="fas fa-check text-xs"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('izin.reject', $izin->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-1.5 bg-rose-500 hover:bg-rose-600 text-white rounded-lg transition-colors flex items-center justify-center" title="Tolak">
                                                    <i class="fas fa-xmark text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold text-xs italic">
                                    Belum ada pengajuan izin terbaru.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Mobile View Cards --}}
                <div class="md:hidden divide-y divide-slate-50">
                    @forelse($recentIzinSubmissions as $izin)
                    <div class="p-5 space-y-3">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <h4 class="text-sm font-black text-slate-800 leading-tight">{{ $izin->siswa->nama ?? 'Siswa Tidak Diketahui' }}</h4>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">{{ $izin->siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}</p>
                            </div>
                            <div class="shrink-0">
                                @php
                                    $badgeClass = match($izin->status) {
                                        'approve', 'Disetujui' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'reject', 'Ditolak' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        default => 'bg-amber-50 text-amber-600 border-amber-100'
                                    };
                                    $statusLabel = match($izin->status) {
                                        'approve', 'Disetujui' => 'Disetujui',
                                        'reject', 'Ditolak' => 'Ditolak',
                                        default => 'Menunggu'
                                    };
                                @endphp
                                <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase border {{ $badgeClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider border 
                                @if($izin->tipe == 'Sakit') bg-rose-50 text-rose-600 border-rose-100
                                @elseif($izin->tipe == 'Masuk Telat') bg-orange-50 text-orange-600 border-orange-100
                                @elseif($izin->tipe == 'Keluar Sekolah') bg-purple-50 text-purple-600 border-purple-100
                                @else bg-blue-50 text-blue-600 border-blue-100
                                @endif">
                                {{ $izin->tipe }}
                            </span>
                            <span class="text-[10px] text-slate-500 italic truncate max-w-[200px]">"{{ $izin->alasan }}"</span>
                        </div>
                        
                        <div class="flex items-center gap-2 pt-1">
                            @if($izin->bukti)
                                <a href="{{ asset($izin->bukti) }}" target="_blank" class="px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg text-[9px] font-black uppercase tracking-wider flex items-center gap-1">
                                    <i class="fas fa-image"></i> Bukti
                                </a>
                            @endif
                            @if($izin->latitude && $izin->longitude)
                                <a href="https://www.google.com/maps?q={{ $izin->latitude }},{{ $izin->longitude }}" target="_blank" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[9px] font-black uppercase tracking-wider flex items-center gap-1">
                                    <i class="fas fa-location-dot"></i> Lokasi
                                </a>
                            @endif
                            
                            @if($izin->status == 'pending')
                                <form action="{{ route('izin.approve', $izin->id) }}" method="POST" class="inline flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-[9px] font-black uppercase tracking-wider flex items-center justify-center gap-1 shadow-sm">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('izin.reject', $izin->id) }}" method="POST" class="inline flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-1.5 bg-rose-500 hover:bg-rose-600 text-white rounded-lg text-[9px] font-black uppercase tracking-wider flex items-center justify-center gap-1 shadow-sm">
                                        <i class="fas fa-xmark"></i> Tolak
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Belum ada pengajuan izin.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Right Column: Aktivitas Terbaru (Matches mockup) -->
        <div class="bg-white rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.01)] border border-slate-100 p-6 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Aktivitas Terbaru</h3>
                    <a href="#" class="text-[10px] font-black text-slate-400 hover:text-emerald-600 uppercase tracking-widest">Lihat semua</a>
                </div>
                
                <div class="space-y-6">
                    @foreach($activities as $act)
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-sm border {{ $act['color'] }}">
                            <i class="fas {{ $act['icon'] }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-black text-slate-700 leading-snug line-clamp-2">{{ $act['title'] }}</h4>
                            <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase">{{ $act['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-50 text-center">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Sistem Presensi SMKN 7 Purworejo</p>
            </div>
        </div>
        
    </div>
</div>
@endsection
