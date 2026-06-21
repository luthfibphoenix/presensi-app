@extends('layout.app')

@php
    $aksen = 'zinc-600';
    $totalSiswa = \App\Models\Siswa::count();
    $izinMenunggu = \App\Models\Izin::where('status', 'Menunggu')->count();
    $alfaHariIni = \App\Models\Presensi::whereDate('tanggal', today())->where('status', 'Alfa')->distinct()->count('siswa_id');
@endphp

@section('title', 'Dashboard Guru BK')

@section('content')
<div class="space-y-6">
    {{-- Hero Card (Dark zinc gradient style with ambient glow orbs) --}}
    <div class="relative overflow-hidden rounded-[2.5rem] p-6 md:p-8 text-white shadow-2xl transition-all duration-300 hover:shadow-zinc-900/10 animate-slide-up"
         style="background: linear-gradient(135deg, #18181b, #3f3f46);">
        <!-- Decorative glowing orbs -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-zinc-400 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-slate-500 rounded-full blur-3xl opacity-15"></div>

        <div class="relative z-10 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-zinc-200">
                <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full animate-ping"></span>
                BK Portal
            </span>
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight">Halo, Guru BK! 👋</h1>
                <p class="text-xs text-zinc-100/90 font-medium mt-1">Pantau kedisiplinan dan status ketidakhadiran siswa secara berkala.</p>
            </div>
            <div class="flex gap-3 pt-1">
                <a href="{{ route('bk.surat_panggil') }}" class="px-5 py-3 bg-white text-zinc-950 text-xs font-black rounded-2xl flex items-center justify-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95">
                    <i class="fas fa-envelope-open-text text-zinc-600"></i> SURAT PEMANGGILAN
                </a>
                <a href="{{ route('siswa.index') }}" class="px-5 py-3 bg-white/10 border border-white/20 text-white text-xs font-black rounded-2xl flex items-center justify-center gap-1.5 backdrop-blur-sm transition-all hover:bg-white/25 active:scale-95">
                    <i class="fas fa-users text-zinc-300"></i> DATA SISWA
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid (Matches mockup layout but with zinc/dark theme) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Siswa Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Total Siswa</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalSiswa }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-zinc-50 text-zinc-600 flex items-center justify-center text-sm border border-zinc-100">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Murid di bawah pemantauan</p>
        </div>

        <!-- Izin Menunggu Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Izin Menunggu</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $izinMenunggu }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-sm border border-amber-100">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Perlu verifikasi segera</p>
        </div>

        <!-- Alfa Hari Ini Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Alfa Hari Ini</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $alfaHariIni }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-sm border border-rose-100">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Siswa tidak hadir hari ini</p>
        </div>
    </div>

    {{-- Guidance / Information Card --}}
    <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] space-y-4">
        <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Peran & Tanggung Jawab Guru BK</h3>
        <p class="text-xs text-slate-500 leading-relaxed">
            Sebagai Guru Bimbingan Konseling (BK), Anda bertugas memantau status ketidakhadiran siswa secara real-time. Anda dapat melacak siswa yang sering tidak hadir (Alfa), meninjau laporan izin sakit yang tertunda, serta menerbitkan surat pemanggilan resmi bagi siswa yang memerlukan pendampingan bimbingan konseling.
        </p>
        <div class="pt-2 flex flex-wrap gap-2">
            <a href="{{ route('bk.surat_panggil') }}" class="px-4 py-2.5 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 text-xs font-black rounded-xl transition duration-300 flex items-center gap-2">
                <i class="fas fa-file-contract"></i> Buat Surat Panggilan
            </a>
            <a href="{{ route('siswa.index') }}" class="px-4 py-2.5 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 text-xs font-black rounded-xl transition duration-300 flex items-center gap-2">
                <i class="fas fa-users-rectangle"></i> Tinjau Absensi Siswa
            </a>
        </div>
    </div>
</div>
@endsection
