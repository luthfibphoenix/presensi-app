@extends('layouts.ortu_mobile')

@section('content')
<div class="px-4 md:px-0 space-y-6 md:space-y-8">
    <!-- Header Page & Filter -->
    <div class="bg-white p-5 md:p-8 rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Riwayat Absensi</h3>
            <h2 class="text-xl md:text-2xl font-black text-slate-900 leading-tight">Data Kehadiran Siswa</h2>
        </div>
        
        <form action="{{ route('ortu.kehadiran') }}" method="GET" class="w-full md:w-auto flex items-center gap-2">
            <select name="bulan" class="flex-1 md:w-48 bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-teal-500 appearance-none">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == $m ? 'selected' : '' }}>
                        {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <button type="submit" class="w-12 h-12 md:w-14 md:h-14 bg-teal-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-teal-100 hover:bg-teal-600 transition-all">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Tabel Riwayat -->
    <div class="bg-white rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/80">
                    <tr>
                        <th class="px-6 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest">Tanggal / Hari</th>
                        <th class="hidden md:table-cell px-6 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest">Mata Pelajaran</th>
                        <th class="hidden sm:table-cell px-6 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest">Jam Ke</th>
                        <th class="px-6 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest text-center">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($riwayat as $tanggal => $r)
                        @if($r->is_collapsed)
                        {{-- Tampilan 1 Baris untuk Izin/Sakit (Collapse) --}}
                        <tr class="bg-blue-50/40">
                            <td class="px-6 py-5">
                                <p class="text-xs md:text-sm font-black text-slate-800">{{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('d F Y') }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('l') }}</p>
                            </td>
                            <td class="hidden md:table-cell px-6 py-5">
                                <p class="text-xs md:text-sm font-black text-blue-700">Izin Seluruh Mata Pelajaran</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Berlaku untuk {{ $r->total_mapel }} Jam Pelajaran</p>
                            </td>
                            <td class="hidden sm:table-cell px-6 py-5">
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-600 rounded-lg text-[10px] font-black uppercase">
                                    Full Day
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $colorClass = $r->status == 'Sakit' ? 'bg-red-500 text-white border-red-600' : 'bg-blue-500 text-white border-blue-600';
                                @endphp
                                <span class="inline-flex items-center px-4 py-1.5 rounded-xl border {{ $colorClass }} text-[9px] font-black uppercase tracking-tighter shadow-md">
                                    {{ $r->status }}
                                </span>
                            </td>
                        </tr>
                        @else
                            {{-- Tampilan Normal (Per Mapel) --}}
                            @foreach($r->all_items as $item)
                            <tr class="hover:bg-teal-50/30 transition-colors">
                                <td class="px-6 py-5">
                                    @if($loop->first)
                                    <p class="text-xs md:text-sm font-black text-slate-800">{{ Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</p>
                                    @endif
                                </td>
                                <td class="hidden md:table-cell px-6 py-5">
                                    <p class="text-xs md:text-sm font-bold text-slate-700">{{ $item->jadwal->mata_pelajaran ?? 'Umum / Lainnya' }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase">Guru Pengampu Mata Pelajaran</p>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-5">
                                    <span class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase">
                                        JP {{ $item->jadwal->jam_mulai ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $colorClass = match($item->status) {
                                            'Hadir' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                            'Terlambat' => 'bg-amber-100 text-amber-600 border-amber-200',
                                            'Alfa' => 'bg-rose-100 text-rose-600 border-rose-200',
                                            default => 'bg-blue-100 text-blue-600 border-blue-200'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl border {{ $colorClass }} text-[9px] font-black uppercase tracking-tighter shadow-sm">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                <i class="fas fa-calendar-times text-3xl"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Data kehadiran belum tersedia untuk bulan ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
