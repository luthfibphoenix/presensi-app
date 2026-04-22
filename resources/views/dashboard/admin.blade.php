@extends('layout.app')

@section('title', 'Dashboard Administrator')

@section('content')
<div class="space-y-8">
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-purple-700 to-indigo-600 rounded-2xl shadow-lg p-10 text-white flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-4xl font-bold mb-3">Selamat Datang, Admin!</h1>
            <p class="text-purple-50 mb-8 max-w-xl text-sm leading-relaxed opacity-90">Kelola seluruh data akademik, pengguna, dan rekapitulasi kehadiran sekolah dalam satu panel kontrol pusat yang efisien.</p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('guru.index') }}" class="bg-white text-purple-700 hover:bg-purple-50 font-bold py-3 px-8 rounded-xl shadow-md transition-all flex items-center gap-3">
                    <i class="fas fa-user-tie text-lg"></i>
                    Manajemen Guru
                </a>
                <a href="{{ route('laporan.index') }}" class="bg-purple-500/50 hover:bg-purple-500/70 text-white border border-purple-400 font-bold py-3 px-8 rounded-xl transition-all backdrop-blur-sm flex items-center gap-3">
                    <i class="fas fa-chart-bar text-lg"></i>
                    Lihat Laporan
                </a>
            </div>
        </div>
        <div class="hidden lg:block relative z-10 opacity-20">
            <i class="fas fa-user-shield text-[180px]"></i>
        </div>
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-12 transform origin-right"></div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-7 flex items-center gap-6 border border-gray-100">
            <div class="w-14 h-14 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pengguna</p>
                <h3 class="text-3xl font-black text-gray-800">120</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-7 flex items-center gap-6 border border-gray-100">
            <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Siswa</p>
                <h3 class="text-3xl font-black text-gray-800">850</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-7 flex items-center gap-6 border border-gray-100">
            <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fas fa-school text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Kelas</p>
                <h3 class="text-3xl font-black text-gray-800">32</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-7 flex items-center gap-6 border border-gray-100">
            <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Jadwal Aktif</p>
                <h3 class="text-3xl font-black text-gray-800">154</h3>
            </div>
        </div>
    </div>
</div>
@endsection
