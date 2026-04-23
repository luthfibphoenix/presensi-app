@extends('layouts.ortu_mobile')

@section('content')
<div class="px-4 md:px-0 space-y-6 md:space-y-8">
    <!-- Header Page -->
    <div class="bg-white p-5 md:p-8 rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 flex items-center justify-between gap-6">
        <div>
            <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Daftar Izin</h3>
            <h2 class="text-xl md:text-2xl font-black text-slate-900 leading-tight">Pengajuan Izin Siswa</h2>
        </div>
        <div class="hidden sm:flex items-center gap-2 text-teal-500 bg-teal-50 px-4 py-2 rounded-2xl border border-teal-100">
            <i class="fas fa-file-signature"></i>
            <span class="text-xs font-black uppercase tracking-tighter">Status Monitoring</span>
        </div>
    </div>

    <!-- List of Permissions (Desktop: Grid 2 Columns, Mobile: 1 Column) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($izins as $izin)
        <div class="bg-white p-6 md:p-8 rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 group hover:border-teal-200 transition-all">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center text-lg md:text-xl border border-teal-100 shadow-inner group-hover:scale-105 transition-transform">
                        <i class="fas {{ $izin->tipe == 'Sakit' ? 'fa-hospital-user' : 'fa-envelope-open-text' }}"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ $izin->tipe }}</p>
                        <h4 class="text-sm md:text-base font-black text-slate-800">{{ Carbon\Carbon::parse($izin->tanggal)->translatedFormat('d F Y') }}</h4>
                    </div>
                </div>
                <div>
                    @php
                        $statusColor = $izin->status == 'Disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100';
                    @endphp
                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl {{ $statusColor }} border text-[9px] font-black uppercase shadow-sm">
                        {{ $izin->status }}
                    </span>
                </div>
            </div>
            
            <div class="relative bg-slate-50 p-5 rounded-3xl border border-slate-100">
                <i class="fas fa-quote-left absolute top-4 left-4 text-teal-200 text-xs opacity-50"></i>
                <p class="text-[11px] md:text-xs font-medium text-slate-600 leading-relaxed italic pl-6 pr-4">
                    {{ $izin->alasan }}
                </p>
            </div>

            @if($izin->status == 'Disetujui')
            <div class="mt-4 flex items-center gap-2 text-[9px] font-bold text-slate-400 px-2 uppercase tracking-tighter">
                <i class="fas fa-user-check text-emerald-500"></i>
                <span>Disetujui oleh Petugas Sekolah</span>
            </div>
            @endif
        </div>
        @empty
        <div class="lg:col-span-2 bg-white p-20 rounded-[3rem] text-center border border-teal-50 shadow-sm flex flex-col items-center">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-slate-200">
                <i class="fas fa-file-invoice text-4xl"></i>
            </div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest italic">Belum ada pengajuan izin terdaftar</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
