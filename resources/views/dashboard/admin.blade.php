@extends('layout.app')

@php
    $aksen = 'purple-600';
    $totalSiswa = \App\Models\Siswa::count();
    $totalGuru = \App\Models\User::count();
    $totalKelas = \App\Models\Kelas::count();
    $totalJadwal = \App\Models\Jadwal::count();
@endphp

@section('title', 'Dashboard Administrator')

@section('content')
<div class="space-y-6">
    {{-- Hero Card (Purple gradient style with ambient glow orbs) --}}
    <div class="relative overflow-hidden rounded-[2.5rem] p-6 md:p-8 text-white shadow-2xl transition-all duration-300 hover:shadow-purple-900/10 animate-slide-up"
         style="background: linear-gradient(135deg, #1b092b, #7c3aed);">
        <!-- Decorative glowing orbs -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-purple-400 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-fuchsia-500 rounded-full blur-3xl opacity-15"></div>

        <div class="relative z-10 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-purple-200">
                <span class="w-1.5 h-1.5 bg-purple-400 rounded-full animate-ping"></span>
                Admin Portal
            </span>
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight">Halo, Admin! 👋</h1>
                <p class="text-xs text-purple-100/90 font-medium mt-1">Sistem kendali utama presensi SMKN 7 Purworejo.</p>
            </div>
            <div class="flex gap-3 pt-1">
                <a href="{{ route('guru.index') }}" class="px-5 py-3 bg-white text-purple-950 text-xs font-black rounded-2xl flex items-center justify-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95">
                    <i class="fas fa-user-tie text-purple-600"></i> MANAJEMEN GURU
                </a>
                <a href="{{ route('laporan.index') }}" class="px-5 py-3 bg-white/10 border border-white/20 text-white text-xs font-black rounded-2xl flex items-center justify-center gap-1.5 backdrop-blur-sm transition-all hover:bg-white/25 active:scale-95">
                    <i class="fas fa-chart-line text-purple-300"></i> LIHAT LAPORAN
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid (Matches mockup layout but with purple accent theme) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Guru Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Guru</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalGuru }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-sm border border-purple-100">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Total terdaftar</p>
        </div>

        <!-- Siswa Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Siswa</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalSiswa }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-fuchsia-50 text-fuchsia-600 flex items-center justify-center text-sm border border-fuchsia-100">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Total terdaftar</p>
        </div>

        <!-- Kelas Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Kelas</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalKelas }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm border border-indigo-100">
                    <i class="fas fa-school"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Total terdaftar</p>
        </div>

        <!-- Jadwal Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Jadwal</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalJadwal }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center text-sm border border-violet-100">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Jadwal pelajaran aktif</p>
        </div>
    </div>

    {{-- System Quick Shortcuts --}}
    <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)]">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Pintasan Cepat Manajemen</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('guru.index') }}" class="flex items-center gap-3.5 p-4 rounded-2xl border border-slate-100 hover:border-purple-200 hover:bg-slate-50 transition duration-300">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h4 class="text-xs font-black text-slate-700">Data Guru</h4>
                    <p class="text-[9px] text-slate-400 font-bold mt-0.5 uppercase">Kelola Akun</p>
                </div>
            </a>
            
            <a href="{{ route('siswa.index') }}" class="flex items-center gap-3.5 p-4 rounded-2xl border border-slate-100 hover:border-purple-200 hover:bg-slate-50 transition duration-300">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h4 class="text-xs font-black text-slate-700">Data Siswa</h4>
                    <p class="text-[9px] text-slate-400 font-bold mt-0.5 uppercase">Kelola Profil</p>
                </div>
            </a>

            <a href="{{ route('kelas.index') }}" class="flex items-center gap-3.5 p-4 rounded-2xl border border-slate-100 hover:border-purple-200 hover:bg-slate-50 transition duration-300">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h4 class="text-xs font-black text-slate-700">Data Kelas</h4>
                    <p class="text-[9px] text-slate-400 font-bold mt-0.5 uppercase">Kelola Rombel</p>
                </div>
            </a>

            <a href="{{ route('admin.password.index') }}" class="flex items-center gap-3.5 p-4 rounded-2xl border border-slate-100 hover:border-purple-200 hover:bg-slate-50 transition duration-300">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                    <i class="fas fa-key"></i>
                </div>
                <div>
                    <h4 class="text-xs font-black text-slate-700">Reset Sandi</h4>
                    <p class="text-[9px] text-slate-400 font-bold mt-0.5 uppercase">Ubah Password</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
