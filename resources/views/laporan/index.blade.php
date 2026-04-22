@extends('layout.app')

@section('title', 'Laporan Presensi')

@section('content')
<div class="h-full flex flex-col gap-6 overflow-hidden">
    {{-- Header Section --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                <i class="fas fa-chart-line text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-black text-gray-800 uppercase tracking-tight">Laporan Presensi Siswa</h2>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Ringkasan kehadiran harian seluruh kelas</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-2xl border border-gray-100">
            <i class="far fa-calendar-alt text-blue-500"></i>
            <span class="text-[10px] font-black text-gray-600 uppercase tracking-widest">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    {{-- Data Table Section --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm flex-1 flex flex-col overflow-hidden">
        <div class="flex-1 overflow-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-white/80 backdrop-blur-md z-10">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Waktu</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Nama Siswa</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Kelas</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Mata Pelajaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($presensis as $presensi)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-gray-800">{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d/m/Y') }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">HARI INI</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 font-black text-[10px] group-hover:bg-white transition-colors">
                                    {{ substr($presensi->siswa->nama ?? '?', 0, 1) }}
                                </div>
                                <span class="text-xs font-black text-gray-800">{{ $presensi->siswa->nama ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] font-black rounded-lg uppercase tracking-wider">
                                {{ $presensi->jadwal->kelas ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-8 py-4">
                            @if($presensi->status == 'Hadir')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full border border-emerald-100">
                                    <i class="fas fa-check-circle text-[8px]"></i>
                                    {{ $presensi->status }}
                                </span>
                            @elseif($presensi->status == 'Alfa')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-full border border-red-100">
                                    <i class="fas fa-times-circle text-[8px]"></i>
                                    {{ $presensi->status }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full border border-amber-100">
                                    <i class="fas fa-info-circle text-[8px]"></i>
                                    {{ $presensi->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-xs font-bold text-gray-500 italic">{{ $presensi->jadwal->mata_pelajaran ?? '-' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-clipboard-list text-4xl mb-4"></i>
                                <p class="text-xs font-black uppercase tracking-widest">Belum ada data laporan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($presensis->hasPages())
        <div class="p-6 border-t border-gray-50 bg-gray-50/30 flex-shrink-0">
            {{ $presensis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
