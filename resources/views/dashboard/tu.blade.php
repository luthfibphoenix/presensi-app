@extends('layout.app')

@section('title', 'Dashboard Tata Usaha')

@section('content')
<div class="h-full flex flex-col gap-4 md:gap-6 overflow-y-auto no-scrollbar pb-24 md:pb-10">
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-br from-indigo-900 via-slate-900 to-black rounded-3xl shadow-lg p-6 md:p-8 text-white relative overflow-hidden border border-slate-700 flex-shrink-0">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-[9px] font-black uppercase tracking-widest mb-4 border border-white/20">
                <i class="fas fa-briefcase text-[8px]"></i>
                Administrative Portal
            </div>
            <h1 class="text-2xl md:text-3xl font-black mb-2 leading-tight tracking-tight">Halo, {{ auth()->user()->fullname }}! 👋</h1>
            <p class="text-indigo-100 mb-6 max-w-xl text-[10px] md:text-xs leading-relaxed opacity-80 font-bold uppercase tracking-wide">Kelola administrasi persuratan dan database sekolah dengan mudah.</p>
            
            <div class="flex gap-3">
                <a href="{{ route('tu.surat_dinas') }}" class="bg-white text-indigo-900 font-black py-2.5 px-6 rounded-xl shadow-md flex items-center justify-center gap-2 text-xs">
                    <i class="fas fa-plane-departure"></i>
                    Surat Dinas
                </a>
                <a href="{{ route('siswa.index') }}" class="bg-indigo-600 text-white border border-indigo-400 font-black py-2.5 px-6 rounded-xl flex items-center justify-center gap-2 text-xs">
                    <i class="fas fa-users"></i>
                    Database Siswa
                </a>
            </div>
        </div>
        <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-[80px]"></div>
    </div>

    {{-- Stats Grid (Administrative Focus) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 flex-shrink-0">
        @php
            $totalSiswa = \App\Models\Siswa::count();
            $totalGuru = \App\Models\User::count();
            $suratHariIni = 0; // Placeholder for future SPD tracking
            $kelasAktif = \App\Models\Kelas::count();
        @endphp
        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 flex-shrink-0">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Total Siswa</p>
                <h3 class="text-lg font-black text-gray-800 leading-none">{{ $totalSiswa }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 flex-shrink-0">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Pegawai/Guru</p>
                <h3 class="text-lg font-black text-gray-800 leading-none">{{ $totalGuru }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 flex-shrink-0">
                <i class="fas fa-school"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Total Kelas</p>
                <h3 class="text-lg font-black text-gray-800 leading-none">{{ $kelasAktif }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 flex-shrink-0">
                <i class="fas fa-file-contract"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Surat Dinas</p>
                <h3 class="text-lg font-black text-gray-800 leading-none">Aktif</h3>
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
