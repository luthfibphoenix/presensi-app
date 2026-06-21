@extends('layout.app')

@php
    $aksen = 'violet-600';
    $totalSiswa = \App\Models\Siswa::count();
    $totalGuru = \App\Models\User::count();
    $kelasAktif = \App\Models\Kelas::count();
@endphp

@section('title', 'Dashboard Tata Usaha')

@section('content')
<div class="space-y-6">
    {{-- Hero Card (Violet gradient style with ambient glow orbs) --}}
    <div class="relative overflow-hidden rounded-[2.5rem] p-6 md:p-8 text-white shadow-2xl transition-all duration-300 hover:shadow-violet-900/10 animate-slide-up"
         style="background: linear-gradient(135deg, #1c0c30, #7c3aed);">
        <!-- Decorative glowing orbs -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-violet-400 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-indigo-500 rounded-full blur-3xl opacity-15"></div>

        <div class="relative z-10 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-violet-200">
                <span class="w-1.5 h-1.5 bg-violet-400 rounded-full animate-ping"></span>
                TU Portal
            </span>
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight">Halo, {{ auth()->user()->fullname ?? auth()->user()->nama }}! 👋</h1>
                <p class="text-xs text-violet-100/90 font-medium mt-1">Kelola administrasi dan surat dinas sekolah dengan mudah.</p>
            </div>
            <div class="flex gap-3 pt-1">
                <a href="{{ route('tu.surat_dinas') }}" class="px-5 py-3 bg-white text-violet-950 text-xs font-black rounded-2xl flex items-center justify-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95">
                    <i class="fas fa-plane-departure text-violet-600"></i> SURAT DINAS
                </a>
                <a href="{{ route('siswa.index') }}" class="px-5 py-3 bg-white/10 border border-white/20 text-white text-xs font-black rounded-2xl flex items-center justify-center gap-1.5 backdrop-blur-sm transition-all hover:bg-white/25 active:scale-95">
                    <i class="fas fa-users text-violet-300"></i> DATA SISWA
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid (Matches mockup layout but with violet accent theme) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Siswa Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Siswa</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalSiswa }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center text-sm border border-violet-100">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Total murid aktif</p>
        </div>

        <!-- Pegawai Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Pegawai</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalGuru }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm border border-indigo-100">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Guru & Staf</p>
        </div>

        <!-- Kelas Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Kelas</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $kelasAktif }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center text-sm border border-violet-100">
                    <i class="fas fa-school"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Rombongan belajar</p>
        </div>

        <!-- SPD Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">SPD</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">Aktif</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-sm border border-purple-100">
                    <i class="fas fa-plane-departure"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Surat Perintah Dinas</p>
        </div>
    </div>

    {{-- Monitoring Sections --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Monitoring Presensi Kelas --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Monitoring Presensi Kelas</h3>
                <span class="px-2.5 py-1 bg-red-50 text-red-700 text-[8px] font-black uppercase rounded-lg border border-red-100">Status Harian</span>
            </div>
            <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto pr-2">
                @forelse($kelasBelumPresensi as $kelas)
                    <div class="px-3 py-2 bg-slate-50 text-slate-700 text-[10px] font-black rounded-xl border border-slate-100 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                        Kelas {{ $kelas }}
                    </div>
                @empty
                    <div class="flex items-center gap-2 text-[10px] font-bold text-emerald-600 uppercase tracking-wide">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        Semua kelas sedang melakukan KBM ✨
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Rekap Ketidakhadiran Siswa --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rekap Ketidakhadiran Siswa</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[8px] font-black uppercase rounded-lg border border-blue-100">Info Global</span>
            </div>
            <div class="space-y-2 overflow-y-auto max-h-40 pr-2">
                @forelse($rekapAbsen as $kelas => $presensis)
                    <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-black text-slate-700">Kelas {{ $kelas }}</span>
                        <div class="flex gap-1.5">
                            @php
                                $counts = $presensis->groupBy('status')->map->count();
                            @endphp
                            @if($counts->has('Alfa')) <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[8px] font-black rounded-md border border-red-100">A: {{ $counts['Alfa'] }}</span> @endif
                            @if($counts->has('Izin')) <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[8px] font-black rounded-md border border-blue-100">I: {{ $counts['Izin'] }}</span> @endif
                            @if($counts->has('Sakit')) <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[8px] font-black rounded-md border border-amber-100">S: {{ $counts['Sakit'] }}</span> @endif
                        </div>
                    </div>
                @empty
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide italic text-center">Belum ada data ketidakhadiran hari ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
