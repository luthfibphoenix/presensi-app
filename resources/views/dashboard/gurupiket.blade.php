@extends('layout.app')

@section('title', 'Dashboard Guru Piket')

@section('content')
<div class="space-y-6">
    <!-- Header Welcome -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Halo, {{ auth()->user()->fullname }} 👋</h2>
            <p class="text-sm font-bold text-slate-400">Selamat bertugas sebagai Guru Piket hari ini.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('izin.guru') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-black shadow-lg shadow-blue-100 transition-all text-xs uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Input Izin
            </a>
            <a href="{{ route('laporan.rekap_harian') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-3 rounded-2xl font-black transition-all text-xs uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-file-invoice"></i> Rekap Harian
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-emerald-50 p-6 rounded-[2.5rem] border border-emerald-100 shadow-sm text-center">
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Hadir</p>
            <p class="text-3xl font-black text-emerald-700">{{ $stats['hadir'] }}</p>
        </div>
        <div class="bg-amber-50 p-6 rounded-[2.5rem] border border-amber-100 shadow-sm text-center">
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1">Izin</p>
            <p class="text-3xl font-black text-amber-700">{{ $stats['izin'] }}</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-[2.5rem] border border-blue-100 shadow-sm text-center">
            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Sakit</p>
            <p class="text-3xl font-black text-blue-700">{{ $stats['sakit'] }}</p>
        </div>
        <div class="bg-rose-50 p-6 rounded-[2.5rem] border border-rose-100 shadow-sm text-center">
            <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-1">Alfa</p>
            <p class="text-3xl font-black text-rose-700">{{ $stats['alfa'] }}</p>
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
                            <div class="font-bold text-slate-700 text-sm">{{ $absent->siswa->nama }}</div>
                            <div class="text-[10px] text-slate-400 font-medium italic">ID: {{ $absent->siswa->nis }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-500">
                            {{ $absent->siswa->kelas->nama_kelas }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs font-bold text-slate-600">{{ $absent->jadwal->mata_pelajaran }}</div>
                            <div class="text-[10px] text-slate-400 font-medium italic">Jam ke-{{ $absent->jadwal->jam_mulai }} - {{ $absent->jadwal->jam_selesai }}</div>
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
                    <h4 class="text-sm font-black text-slate-800">{{ $absent->siswa->nama }}</h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mb-2">{{ $absent->siswa->kelas->nama_kelas }}</p>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[8px] font-black uppercase italic">JP {{ $absent->jadwal->jam_mulai }}</span>
                        <span class="text-[9px] font-bold text-slate-500 truncate max-w-[120px]">{{ $absent->jadwal->mata_pelajaran }}</span>
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
