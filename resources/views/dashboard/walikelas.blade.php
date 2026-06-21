@extends('layout.app')

@php
    $aksen = 'indigo-600';
    $user = auth()->user();
    // Get homeroom class name and total students
    $kelasWali = \App\Models\Kelas::where('wali_id', $user->id)->first();
    $namaKelas = $kelasWali ? $kelasWali->nama_kelas : 'Kelas Wali';
    $totalSiswaWali = $kelasWali ? \App\Models\Siswa::where('kelas_id', $kelasWali->id)->count() : 0;
@endphp

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="space-y-6">
    {{-- Hero Card (Indigo gradient style with ambient glow orbs) --}}
    <div class="relative overflow-hidden rounded-[2.5rem] p-6 md:p-8 text-white shadow-2xl transition-all duration-300 hover:shadow-indigo-900/10 animate-slide-up"
         style="background: linear-gradient(135deg, #1e1b4b, #4f46e5);">
        <!-- Decorative glowing orbs -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-indigo-400 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-violet-500 rounded-full blur-3xl opacity-15"></div>

        <div class="relative z-10 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-indigo-200">
                <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full animate-ping"></span>
                Wali Kelas Portal
            </span>
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight">Halo, Wali Kelas {{ $namaKelas }}! 👋</h1>
                <p class="text-xs text-indigo-100/90 font-medium mt-1">Kelola dan pantau presensi harian siswa binaan Anda secara khusus.</p>
            </div>
            <div class="flex gap-3 pt-1">
                <a href="{{ route('siswa.index') }}" class="px-5 py-3 bg-white text-indigo-950 text-xs font-black rounded-2xl flex items-center justify-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95">
                    <i class="fas fa-users text-indigo-600"></i> MANAJEMEN SISWA WALI
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid (Matches mockup layout but with indigo theme) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Siswa Wali Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Siswa Wali</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalSiswaWali }} Anak</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm border border-indigo-100">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Total siswa di rombel {{ $namaKelas }}</p>
        </div>

        <!-- Rombel Info Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Kelas Diampu</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $namaKelas }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center text-sm border border-violet-100">
                    <i class="fas fa-school"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Kelas wali aktif</p>
        </div>
    </div>

    {{-- homeroom description card --}}
    <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] space-y-4">
        <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Peran Wali Kelas</h3>
        <p class="text-xs text-slate-500 leading-relaxed">
            Sebagai Wali Kelas, Anda memiliki wewenang tambahan untuk memantau rekapitulasi kehadiran siswa di kelas Anda secara khusus. Anda dapat melihat laporan absensi berkala, menindaklanjuti ketidakhadiran berturut-turut, serta mengarahkan siswa yang membutuhkan bimbingan lebih lanjut ke Guru BK.
        </p>
    </div>
</div>
@endsection
