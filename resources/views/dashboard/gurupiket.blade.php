@extends('layout.app')

@php
    $aksen = 'green-600';
@endphp


@section('title', 'Dashboard Guru Piket')

@section('content')
<div class="space-y-6">
    <!-- Header Welcome -->
    {{-- Hero Card --}}
    <div class="mx-0 mt-0 rounded-2xl p-5 text-white shadow-lg"
         style="background: linear-gradient(135deg, #14532d, #16a34a)">
        <span class="text-[10px] font-bold bg-white/20 backdrop-blur-md rounded-full px-3 py-1 uppercase tracking-wider">
            PIKET PORTAL
        </span>
        <h1 class="text-xl font-bold mt-3">Halo, {{ auth()->user()->fullname ?? auth()->user()->nama }}! 👋</h1>
        <p class="text-sm opacity-90 mt-1">Selamat bertugas sebagai Guru Piket hari ini.</p>
        <div class="flex gap-3 mt-4">
            <a href="{{ route('izin.guru') }}" class="bg-white text-green-700 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm active:scale-95 transition-transform">
                <i class="fas fa-plus-circle"></i> Input Izin
            </a>
            <a href="{{ route('laporan.rekap_harian') }}" class="bg-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 backdrop-blur-sm active:scale-95 transition-transform">
                <i class="fas fa-file-invoice"></i> Rekap Harian
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                    <i class="fas fa-user-check text-green-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Hadir</p>
                    <p class="text-xl font-bold text-gray-800">{{ $stats['hadir'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                    <i class="fas fa-envelope-open-text text-green-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Izin</p>
                    <p class="text-xl font-bold text-gray-800">{{ $stats['izin'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                    <i class="fas fa-hand-holding-medical text-green-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Sakit</p>
                    <p class="text-xl font-bold text-gray-800">{{ $stats['sakit'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                    <i class="fas fa-user-times text-green-600"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Alfa</p>
                    <p class="text-xl font-bold text-gray-800">{{ $stats['alfa'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity / Absent Students -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Siswa Tidak Hadir Hari Ini</h3>
            <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
        {{-- Desktop View --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Siswa</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Kelas</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Mapel / Jam</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($absentStudents as $absent)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 text-sm">{{ $absent->siswa->nama ?? 'Siswa Tidak Diketahui' }}</div>
                            <div class="text-[10px] text-slate-400 font-medium italic">ID: {{ $absent->siswa->nis ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-500">
                            {{ $absent->siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs font-bold text-slate-600">{{ $absent->jadwal->mata_pelajaran ?? '-' }}</div>
                            <div class="text-[10px] text-slate-400 font-medium italic">Jam ke-{{ $absent->jadwal->jam_mulai ?? '-' }} - {{ $absent->jadwal->jam_selesai ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $badgeClass = match($absent->status) {
                                    'Alfa' => 'bg-rose-100 text-rose-600',
                                    'Izin' => 'bg-amber-100 text-amber-600',
                                    'Sakit' => 'bg-blue-100 text-blue-600',
                                    default => 'bg-slate-100 text-slate-600'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $badgeClass }}">
                                {{ $absent->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 font-bold text-sm italic">
                            Belum ada catatan ketidakhadiran hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile View --}}
        <div class="md:hidden divide-y divide-slate-50">
            @forelse($absentStudents as $absent)
            <div class="p-5 flex items-center justify-between gap-4">
                <div class="flex-1">
                    <h4 class="text-sm font-black text-slate-800">{{ $absent->siswa->nama ?? 'Siswa Tidak Diketahui' }}</h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mb-2">{{ $absent->siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}</p>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[8px] font-black uppercase italic">JP {{ $absent->jadwal->jam_mulai ?? '-' }}</span>
                        <span class="text-[9px] font-bold text-slate-500 truncate max-w-[120px]">{{ $absent->jadwal->mata_pelajaran ?? '-' }}</span>
                    </div>
                </div>
                <div class="shrink-0">
                    @php
                        $badgeClass = match($absent->status) {
                            'Alfa' => 'bg-rose-100 text-rose-600 border-rose-200',
                            'Izin' => 'bg-amber-100 text-amber-600 border-amber-200',
                            'Sakit' => 'bg-blue-100 text-blue-600 border-blue-200',
                            default => 'bg-slate-100 text-slate-600 border-slate-200'
                        };
                    @endphp
                    <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase border {{ $badgeClass }}">
                        {{ $absent->status }}
                    </span>
                </div>
            </div>
            @empty
            <div class="p-10 text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Belum ada catatan ketidakhadiran.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
