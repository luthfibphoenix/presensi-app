@extends('layout.app')

@php
    $aksen = 'violet-600';
@endphp


@section('title', 'Dashboard Tata Usaha')

@section('content')
@php
    $totalSiswa = \App\Models\Siswa::count();
    $totalGuru = \App\Models\User::count();
    $kelasAktif = \App\Models\Kelas::count();
@endphp

<div class="h-full flex flex-col gap-4 md:gap-6 overflow-y-auto no-scrollbar pb-24 md:pb-10">
    {{-- Welcome Banner --}}
    {{-- Hero Card --}}
    <div class="mx-0 mt-0 rounded-2xl p-5 text-white shadow-lg"
         style="background: linear-gradient(135deg, #4c1d95, #7c3aed)">
        <span class="text-[10px] font-bold bg-white/20 backdrop-blur-md rounded-full px-3 py-1 uppercase tracking-wider">
            ADMINISTRATIVE PORTAL
        </span>
        <h1 class="text-xl font-bold mt-3">Halo, {{ auth()->user()->fullname ?? auth()->user()->nama }}! 👋</h1>
        <p class="text-sm opacity-90 mt-1">Kelola administrasi sekolah dengan mudah.</p>
        <div class="flex gap-3 mt-4">
            <a href="{{ route('tu.surat_dinas') }}" class="bg-white text-violet-700 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm active:scale-95 transition-transform">
                <i class="fas fa-plane-departure"></i> Surat Dinas
            </a>
            <a href="{{ route('siswa.index') }}" class="bg-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 backdrop-blur-sm active:scale-95 transition-transform">
                <i class="fas fa-users"></i> Data Siswa
            </a>
        </div>
    </div>

    {{-- Stats Grid (Administrative Focus) --}}
    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                    <i class="fas fa-user-graduate text-violet-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Siswa</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalSiswa }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-violet-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Pegawai</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalGuru }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                    <i class="fas fa-school text-violet-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Kelas</p>
                    <p class="text-xl font-bold text-gray-800">{{ $kelasAktif }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                    <i class="fas fa-file-contract text-violet-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">SPD</p>
                    <p class="text-xl font-bold text-gray-800">Aktif</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Monitoring Sections --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 flex-shrink-0">
        {{-- Kelas Belum Presensi --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Monitoring Presensi Kelas</h3>
                <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[8px] font-black uppercase rounded-full border border-red-100">Status Harian</span>
            </div>
            <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto custom-scrollbar pr-2">
                @forelse($kelasBelumPresensi as $kelas)
                    <div class="px-4 py-2 bg-gray-50 text-gray-700 text-[10px] font-black rounded-xl border border-gray-100 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-amber-500"></i>
                        Kelas {{ $kelas }}
                    </div>
                @empty
                    <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wide italic">Semua kelas sedang melakukan KBM ✨</p>
                @endforelse
            </div>
        </div>

        {{-- Rekap Siswa Tidak Masuk --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Rekap Ketidakhadiran Siswa</h3>
                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[8px] font-black uppercase rounded-full border border-blue-100">Info Global</span>
            </div>
            <div class="space-y-2 overflow-y-auto max-h-40 custom-scrollbar pr-2">
                @forelse($rekapAbsen as $kelas => $presensis)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl border border-gray-100">
                        <span class="text-[10px] font-black text-gray-700">Kelas {{ $kelas }}</span>
                        <div class="flex gap-2">
                            @php
                                $counts = $presensis->groupBy('status')->map->count();
                            @endphp
                            @if($counts->has('Alfa')) <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[8px] font-black rounded-lg">A: {{ $counts['Alfa'] }}</span> @endif
                            @if($counts->has('Izin')) <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[8px] font-black rounded-lg">I: {{ $counts['Izin'] }}</span> @endif
                            @if($counts->has('Sakit')) <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[8px] font-black rounded-lg">S: {{ $counts['Sakit'] }}</span> @endif
                        </div>
                    </div>
                @empty
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide italic">Belum ada data ketidakhadiran hari ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
