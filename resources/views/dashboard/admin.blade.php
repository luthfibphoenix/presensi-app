@extends('layout.app')

@php
    $aksen = 'purple-600';
@endphp


@section('title', 'Dashboard Administrator')

@section('content')
@php
    $totalSiswa = \App\Models\Siswa::count();
    $totalGuru = \App\Models\User::count();
    $totalKelas = \App\Models\Kelas::count();
    $totalJadwal = \App\Models\Jadwal::count();
@endphp

<div class="space-y-8">
    {{-- Welcome Banner --}}
    {{-- Hero Card --}}
    <div class="mx-0 mt-0 rounded-2xl p-5 text-white shadow-lg"
         style="background: linear-gradient(135deg, #581c87, #9333ea)">
        <span class="text-[10px] font-bold bg-white/20 backdrop-blur-md rounded-full px-3 py-1 uppercase tracking-wider">
            ADMIN PORTAL
        </span>
        <h1 class="text-xl font-bold mt-3">Halo, Admin! 👋</h1>
        <p class="text-sm opacity-90 mt-1">Sistem kendali utama presensi SMKN 7.</p>
        <div class="flex gap-3 mt-4">
            <a href="{{ route('guru.index') }}" class="bg-white text-purple-700 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm active:scale-95 transition-transform">
                <i class="fas fa-user-tie"></i> Manajemen Guru
            </a>
            <a href="{{ route('laporan.index') }}" class="bg-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 backdrop-blur-sm active:scale-95 transition-transform">
                <i class="fas fa-chart-bar"></i> Lihat Laporan
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 gap-3 mt-2">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-user-tie text-purple-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Guru</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalGuru }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-user-graduate text-purple-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Siswa</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalSiswa }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-school text-purple-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Kelas</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalKelas }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-purple-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Jadwal</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalJadwal }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
