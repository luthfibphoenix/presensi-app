@extends('layout.app')

@section('title', 'Rekap Kehadiran Harian')

@section('content')
<div class="w-full flex flex-col gap-6">
    {{-- Header & Filters --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-6 flex-shrink-0">
        <form action="{{ route('laporan.rekap_harian') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Pilih Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $tanggal }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Pilih Kelas</label>
                    <select name="kelas_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelases as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="bg-blue-600 text-white font-black py-3.5 px-8 rounded-2xl shadow-lg hover:bg-blue-700 active:scale-95 transition-all flex items-center gap-3 text-xs uppercase tracking-widest">
                <i class="fas fa-search"></i> Tampilkan
            </button>
        </form>
    </div>

    @if($kelasId)
    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 flex-shrink-0">
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Siswa</p>
            <h3 class="text-2xl font-black text-gray-800">{{ count($siswas) }}</h3>
        </div>
        <div class="bg-emerald-50 rounded-3xl p-6 border border-emerald-100 shadow-sm">
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Hadir Penuh</p>
            <h3 class="text-2xl font-black text-emerald-700">{{ collect($siswas)->where('status_akhir', 'Hadir Penuh')->count() }}</h3>
        </div>
        <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 shadow-sm">
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1">Hadir Sebagian</p>
            <h3 class="text-2xl font-black text-amber-700">{{ collect($siswas)->where('status_akhir', 'Hadir Sebagian')->count() }}</h3>
        </div>
        <div class="bg-red-50 rounded-3xl p-6 border border-red-100 shadow-sm">
            <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1">Alfa</p>
            <h3 class="text-2xl font-black text-red-700">{{ collect($siswas)->where('status_akhir', 'Alfa')->count() }}</h3>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm flex flex-col overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between flex-shrink-0">
            <h3 class="font-black text-gray-800 uppercase tracking-tight">Status Kehadiran Harian</h3>
            <span class="px-4 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full uppercase tracking-widest">
                {{ $totalSchedules }} Jam Pelajaran Terdeteksi
            </span>
        </div>
        <div class="w-full overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-white/80 backdrop-blur-md z-10">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">No</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Nama Siswa</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 text-center">Status Akhir</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 text-right">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($siswas as $index => $siswa)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-4 text-sm font-bold text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-black text-gray-400 uppercase">
                                    {{ substr($siswa->nama, 0, 1) }}
                                </div>
                                <span class="text-sm font-black text-gray-700">{{ $siswa->nama }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex justify-center">
                                @php
                                    $color = match($siswa->status_akhir) {
                                        'Hadir Penuh' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'Hadir Sebagian' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'Alfa' => 'bg-red-50 text-red-600 border-red-100',
                                        'Izin', 'Sakit', 'Dispensasi' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        default => 'bg-gray-100 text-gray-400 border-gray-200'
                                    };
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $color }}">
                                    {{ $siswa->status_akhir }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <span class="text-xs font-bold text-gray-400 italic">{{ $siswa->keterangan }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-user-slash text-4xl mb-4"></i>
                                <p class="text-xs font-black uppercase tracking-[0.2em]">Tidak ada data siswa</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm w-full flex flex-col items-center justify-center p-12">
        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-school text-3xl text-blue-200"></i>
        </div>
        <h3 class="text-xl font-black text-gray-800 mb-2">Pilih Kelas & Tanggal</h3>
        <p class="text-gray-400 text-sm font-medium text-center max-w-sm">Silakan pilih kelas dan tanggal untuk melihat ringkasan kehadiran harian siswa yang terpadu.</p>
    </div>
    @endif
</div>
@endsection
