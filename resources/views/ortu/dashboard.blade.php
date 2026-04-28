@extends('layouts.ortu_mobile')

@section('content')
@section('content')
<div class="px-5 space-y-6">
    <!-- Header Profil Anak -->
    @php
        $aksen = 'cyan-600';
    @endphp
    {{-- Hero Card --}}
    <div class="mx-0 mt-0 rounded-2xl p-5 text-white shadow-lg"
         style="background: linear-gradient(135deg, #0e7490, #06b6d4)">
        <span class="text-[10px] font-bold bg-white/20 backdrop-blur-md rounded-full px-3 py-1 uppercase tracking-wider">
            PORTAL ORANG TUA
        </span>
        <h1 class="text-xl font-bold mt-3">Halo, Orang Tua {{ explode(' ', $siswa->nama)[0] }}! 👋</h1>
        <p class="text-sm opacity-90 mt-1">Pantau kehadiran putra/putri Anda.</p>
        <div class="flex gap-3 mt-4">
            <a href="{{ route('ortu.kehadiran') }}" class="bg-white text-cyan-700 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm active:scale-95 transition-transform">
                <i class="fas fa-clock-rotate-left"></i> Histori
            </a>
            <a href="{{ route('ortu.izin') }}" class="bg-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 backdrop-blur-sm active:scale-95 transition-transform">
                <i class="fas fa-envelope-open-text"></i> Izin
            </a>
        </div>
    </div>

    <!-- Alert Status Harian -->
    @if($statusHarian == 'Alfa')
    <div class="bg-rose-500 p-5 rounded-3xl text-white shadow-xl shadow-rose-100 flex items-center gap-4 animate-slide-up">
        <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div>
            <p class="text-[11px] font-bold leading-tight">Anak Anda tidak hadir tanpa keterangan hari ini.</p>
            <p class="text-[9px] opacity-80 mt-0.5">Mohon segera konfirmasi ke wali kelas.</p>
        </div>
    </div>
    @elseif($statusHarian == 'Hadir Sebagian')
    <div class="bg-amber-500 p-5 rounded-3xl text-white shadow-xl shadow-amber-100 flex items-center gap-4 animate-slide-up">
        <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
            <i class="fas fa-circle-info"></i>
        </div>
        <div>
            <p class="text-[11px] font-bold leading-tight">Hadir Sebagian ({{ $presentCount }}/{{ $totalSchedules }} Jam).</p>
            <p class="text-[9px] opacity-80 mt-0.5">Pantau terus kegiatan belajar anak.</p>
        </div>
    </div>
    @endif

    <!-- Status Kehadiran Hari Ini -->
    <div class="card-neo p-6 rounded-[2.5rem] relative overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Status Hari Ini</h3>
            <span class="text-[9px] font-black text-slate-400">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
        
        <div class="flex items-center gap-5">
            @php
                $icon = 'fa-clock';
                $iconColor = 'text-slate-400';
                $bgColor = 'bg-slate-50';
                if($statusHarian == 'Hadir Penuh') { $icon = 'fa-circle-check'; $iconColor = 'text-emerald-500'; $bgColor = 'bg-emerald-50'; }
                elseif($statusHarian == 'Hadir Sebagian') { $icon = 'fa-circle-dot'; $iconColor = 'text-amber-500'; $bgColor = 'bg-amber-50'; }
                elseif($statusHarian == 'Alfa') { $icon = 'fa-circle-xmark'; $iconColor = 'text-rose-500'; $bgColor = 'bg-rose-50'; }
                elseif(in_array($statusHarian, ['Izin', 'Sakit'])) { $icon = 'fa-envelope-open-text'; $iconColor = 'text-blue-500'; $bgColor = 'bg-blue-50'; }
            @endphp
            
            <div class="w-16 h-16 {{ $bgColor }} {{ $iconColor }} rounded-2xl flex items-center justify-center text-3xl shadow-inner border border-white">
                <i class="fas {{ $icon }}"></i>
            </div>
            <div>
                <h4 class="text-lg font-black text-slate-800 leading-none mb-1">{{ $statusHarian }}</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    @if($totalSchedules > 0)
                        {{ $presentCount }} dari {{ $totalSchedules }} Jam Selesai
                    @else
                        Tidak ada jadwal hari ini
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Grid Rekapitulasi -->
    <div class="space-y-4">
        <h3 class="text-[10px] font-black text-white uppercase tracking-widest px-2 italic">Statistik {{ now()->translatedFormat('F') }}</h3>
    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 gap-3 mt-2">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center">
                    <i class="fas fa-check text-cyan-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Hadir</p>
                    <p class="text-xl font-bold text-gray-800">{{ $rekap['hadir'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center">
                    <i class="fas fa-bolt text-cyan-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Telat</p>
                    <p class="text-xl font-bold text-gray-800">{{ $rekap['terlambat'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center">
                    <i class="fas fa-xmark text-cyan-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Alfa</p>
                    <p class="text-xl font-bold text-gray-800">{{ $rekap['alfa'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center">
                    <i class="fas fa-envelope text-cyan-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Izin</p>
                    <p class="text-xl font-bold text-gray-800">{{ $rekap['izin'] }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
@endsection
