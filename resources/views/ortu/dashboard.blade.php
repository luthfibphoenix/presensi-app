@extends('layouts.ortu_mobile')

@section('content')
<div class="px-4 md:px-0 space-y-6 md:space-y-8">
    <!-- Header Profil Anak (Desktop: Row, Mobile: Col) -->
    <!-- Header Profil Anak (Desktop: Row, Mobile: Col) -->
    <div class="bg-white p-5 md:p-8 rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 flex flex-col md:flex-row items-center gap-5 md:gap-8">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-teal-100 rounded-2xl md:rounded-3xl flex items-center justify-center text-teal-500 text-2xl md:text-3xl shrink-0">
            <i class="fas fa-child"></i>
        </div>
        <div class="text-center md:text-left flex-1">
            <p class="text-[9px] md:text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] mb-1">Akun {{ auth('orangtua')->user()->hubungan }}</p>
            <h2 class="text-xl md:text-2xl font-black text-slate-900 leading-tight mb-2">Halo, {{ auth('orangtua')->user()->nama }} 👋</h2>
            <div class="h-px w-full bg-slate-100 my-3"></div>
            <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Informasi Siswa</p>
            <h3 class="text-lg md:text-xl font-black text-slate-700 leading-tight mb-1">{{ $siswa->nama }}</h3>
            <p class="text-xs md:text-sm font-bold text-slate-500">Kelas {{ $siswa->kelas->nama_kelas }} • NIS: {{ $siswa->nis }}</p>
        </div>
        <div class="w-full md:w-auto px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100 text-center">
            <p class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Status Akademik</p>
            <p class="text-[10px] md:text-xs font-black text-emerald-600">Aktif & Terverifikasi</p>
        </div>
    </div>

    <!-- Banner Ketidakhadiran -->
    @if($statusHarian == 'Alfa')
    <div class="bg-rose-600 p-5 md:p-6 rounded-3xl text-white shadow-xl shadow-rose-100 flex items-center gap-4 animate-pulse">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-full flex items-center justify-center shrink-0">
            <i class="fas fa-exclamation-triangle text-lg"></i>
        </div>
        <p class="text-xs md:text-sm font-bold leading-relaxed">Anak Anda tidak hadir tanpa keterangan hari ini. Harap segera hubungi pihak sekolah.</p>
    </div>
    @elseif($statusHarian == 'Hadir Sebagian')
    <div class="bg-amber-500 p-5 md:p-6 rounded-3xl text-white shadow-xl shadow-amber-100 flex items-center gap-4">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-full flex items-center justify-center shrink-0">
            <i class="fas fa-info-circle text-lg"></i>
        </div>
        <p class="text-xs md:text-sm font-bold leading-relaxed">Anak Anda terdeteksi hadir sebagian hari ini ({{ $presentCount }}/{{ $totalSchedules }} Jam). Harap pantau kegiatan sekolahnya.</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        <!-- Status Hari Ini (Col 1) -->
        <div class="bg-white p-6 rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 lg:col-span-1">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Ringkasan Harian</h3>
                <span class="text-[9px] font-black text-teal-500 bg-teal-50 px-2 py-1 rounded-lg uppercase tracking-tighter">{{ now()->translatedFormat('l') }}</span>
            </div>
            <div class="flex flex-col items-center text-center py-4">
                @php
                    $icon = 'fa-clock';
                    $bgClass = 'bg-slate-50 text-slate-400';
                    if($statusHarian == 'Hadir Penuh') { $icon = 'fa-check-circle'; $bgClass = 'bg-emerald-50 text-emerald-600'; }
                    elseif($statusHarian == 'Hadir Sebagian') { $icon = 'fa-adjust'; $bgClass = 'bg-amber-50 text-amber-600'; }
                    elseif($statusHarian == 'Alfa') { $icon = 'fa-times-circle'; $bgClass = 'bg-rose-50 text-rose-600'; }
                    elseif(in_array($statusHarian, ['Izin', 'Sakit', 'Dispensasi'])) { $icon = 'fa-envelope-open-text'; $bgClass = 'bg-blue-50 text-blue-600'; }
                @endphp
                
                <div class="w-20 h-20 {{ $bgClass }} rounded-[2rem] flex items-center justify-center text-4xl mb-4 border-4 border-white shadow-xl">
                    <i class="fas {{ $icon }}"></i>
                </div>
                <h4 class="text-lg font-black {{ $colorClass }} mb-1">
                    {{ $statusHarian }}
                </h4>
                <p class="text-xs font-bold text-slate-400">
                    @if($totalSchedules > 0)
                        {{ $presentCount }}/{{ $totalSchedules }} Jam Pelajaran
                    @else
                        Tidak Ada Jadwal
                    @endif
                </p>
            </div>
        </div>

        <!-- Rekap Bulan Ini (Col 2-3) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rekap {{ now()->translatedFormat('F') }}</h3>
                <div class="hidden md:flex gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-[2.5rem] border border-teal-50 shadow-sm flex flex-col items-center text-center group hover:bg-teal-50 transition-colors">
                    <span class="text-3xl font-black text-emerald-600 mb-1">{{ $rekap['hadir'] }}</span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Hadir</span>
                </div>
                <div class="bg-white p-6 rounded-[2.5rem] border border-teal-50 shadow-sm flex flex-col items-center text-center group hover:bg-teal-50 transition-colors">
                    <span class="text-3xl font-black text-amber-600 mb-1">{{ $rekap['terlambat'] }}</span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Terlambat</span>
                </div>
                <div class="bg-white p-6 rounded-[2.5rem] border border-teal-50 shadow-sm flex flex-col items-center text-center group hover:bg-teal-50 transition-colors">
                    <span class="text-3xl font-black text-rose-600 mb-1">{{ $rekap['alfa'] }}</span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Alfa</span>
                </div>
                <div class="bg-white p-6 rounded-[2.5rem] border border-teal-50 shadow-sm flex flex-col items-center text-center group hover:bg-teal-50 transition-colors">
                    <span class="text-3xl font-black text-blue-600 mb-1">{{ $rekap['izin'] }}</span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Izin</span>
                </div>
            </div>

            <!-- Motivasi / Info (Desktop Only) -->
            <div class="hidden md:block bg-teal-600 p-8 rounded-[40px] text-white relative overflow-hidden shadow-xl shadow-teal-100">
                <div class="relative z-10">
                    <h4 class="text-xl font-black mb-2 leading-tight">Bersama Memantau <br>Masa Depan Anak</h4>
                    <p class="text-sm font-medium opacity-80 leading-relaxed max-w-sm">Kehadiran yang konsisten adalah langkah pertama menuju kesuksesan akademik. Mari bekerja sama memastikan kehadiran setiap hari.</p>
                </div>
                <i class="fas fa-graduation-cap absolute -right-6 -bottom-6 text-9xl opacity-20 rotate-12"></i>
            </div>
        </div>
    </div>
</div>
@endsection
