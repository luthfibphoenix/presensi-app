@extends('layouts.ortu_mobile')

@section('content')
@section('content')
<div class="px-5 space-y-6">
    <!-- Header Profil Anak -->
    <div class="card-neo p-6 rounded-[2.5rem] flex flex-col items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-teal-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
        
        <div class="w-20 h-20 bg-teal-100 rounded-3xl flex items-center justify-center text-teal-600 text-3xl shadow-inner relative z-10">
            <i class="fas fa-user-graduate"></i>
        </div>
        
        <div class="text-center relative z-10">
            <p class="text-[9px] font-black text-teal-500 uppercase tracking-[0.2em] mb-1">Informasi Siswa</p>
            <h3 class="text-xl font-black text-slate-800 leading-tight">{{ $siswa->nama }}</h3>
            <div class="flex items-center justify-center gap-2 mt-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-[10px] font-bold text-slate-500">Kelas {{ $siswa->kelas->nama_kelas }}</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-[10px] font-bold text-slate-500">NIS: {{ $siswa->nis }}</span>
            </div>
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
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="card-neo p-5 rounded-[2rem] flex items-center gap-4">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <p class="text-xl font-black text-slate-800 leading-none">{{ $rekap['hadir'] }}</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter mt-1">Hadir</p>
                </div>
            </div>
            <div class="card-neo p-5 rounded-[2rem] flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <p class="text-xl font-black text-slate-800 leading-none">{{ $rekap['terlambat'] }}</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter mt-1">Telat</p>
                </div>
            </div>
            <div class="card-neo p-5 rounded-[2rem] flex items-center gap-4">
                <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-xmark"></i>
                </div>
                <div>
                    <p class="text-xl font-black text-slate-800 leading-none">{{ $rekap['alfa'] }}</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter mt-1">Alfa</p>
                </div>
            </div>
            <div class="card-neo p-5 rounded-[2rem] flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <p class="text-xl font-black text-slate-800 leading-none">{{ $rekap['izin'] }}</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter mt-1">Izin</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endsection
