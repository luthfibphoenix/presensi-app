@extends('layout.app')

@section('title', 'Riwayat Presensi')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Riwayat Kehadiran</h1>
            <p class="text-sm text-gray-500">Daftar kehadiran Anda di seluruh mata pelajaran.</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
    <!-- Table Section (Desktop) / Card List (Mobile) -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Mata Pelajaran</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Kelas</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($riwayats as $riwayat)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d M Y') }}</div>
                            <div class="text-[10px] text-gray-400 font-medium">{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('l') }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-sm font-black text-gray-900 leading-tight">{{ $riwayat->jadwal->mata_pelajaran ?? 'N/A' }}</div>
                            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Semester {{ $riwayat->jadwal->semester ?? '-' }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-gray-600">{{ $riwayat->jadwal->kelas ?? 'N/A' }}</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'Hadir' => 'bg-emerald-100 text-emerald-700',
                                    'Terlambat' => 'bg-amber-100 text-amber-700',
                                    'Sakit' => 'bg-blue-100 text-blue-700',
                                    'Izin' => 'bg-purple-100 text-purple-700',
                                    'Alfa' => 'bg-red-100 text-red-700',
                                ];
                                $badgeClass = $statusClasses[$riwayat->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <div class="flex flex-col gap-1">
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest inline-flex items-center justify-center w-fit {{ $badgeClass }}">
                                    {{ $riwayat->status }}
                                </span>
                                @if($riwayat->status === 'Terlambat' && $riwayat->terlambat_menit > 0)
                                    <span class="text-[10px] font-bold text-amber-500 italic">
                                        <i class="fas fa-clock mr-1"></i> Terlambat {{ $riwayat->terlambat_menit }} menit
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center opacity-30">
                                <i class="fas fa-history text-5xl mb-4"></i>
                                <p class="text-lg font-black tracking-tight">Belum ada riwayat absensi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden divide-y divide-gray-50">
            @forelse($riwayats as $riwayat)
            <div class="p-5 flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">
                        {{ \Carbon\Carbon::parse($riwayat->tanggal)->translatedFormat('d M Y') }}
                    </div>
                    <h3 class="text-sm font-black text-gray-900 leading-tight mb-1">{{ $riwayat->jadwal->mata_pelajaran ?? 'N/A' }}</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                        Kelas {{ $riwayat->jadwal->kelas ?? 'N/A' }}
                    </p>
                </div>
                <div class="flex flex-col items-end gap-1.5">
                    @php
                        $statusClasses = [
                            'Hadir' => 'bg-emerald-100 text-emerald-700',
                            'Terlambat' => 'bg-amber-100 text-amber-700',
                            'Sakit' => 'bg-blue-100 text-blue-700',
                            'Izin' => 'bg-purple-100 text-purple-700',
                            'Alfa' => 'bg-red-100 text-red-700',
                        ];
                        $badgeClass = $statusClasses[$riwayat->status] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                        {{ $riwayat->status }}
                    </span>
                    @if($riwayat->status === 'Terlambat' && $riwayat->terlambat_menit > 0)
                        <span class="text-[9px] font-bold text-amber-500 whitespace-nowrap">
                            {{ $riwayat->terlambat_menit }}m
                        </span>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-10 text-center opacity-30">
                <i class="fas fa-history text-4xl mb-3"></i>
                <p class="text-sm font-black uppercase tracking-widest">Kosong</p>
            </div>
            @endforelse
        </div>

        @if($riwayats->hasPages())
        <div class="px-8 py-6 border-t border-gray-50 bg-gray-50/30">
            {{ $riwayats->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
