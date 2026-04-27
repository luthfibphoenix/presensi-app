@extends('layout.app')
@section('title', 'Semua Jadwal')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-100">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 tracking-tight">Beban Mengajar</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Daftar Mata Pelajaran & Kelas</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-white border border-slate-100 rounded-full text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                Total: {{ $jadwals->count() }} Item
            </span>
        </div>
        
        <div class="divide-y divide-slate-50">
            @forelse($jadwals as $jadwal)
                <div class="px-8 py-5 flex items-center justify-between hover:bg-blue-50/30 transition-colors group">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 bg-white rounded-2xl border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:border-blue-100 transition-all shadow-sm">
                            <i class="fas fa-book-open text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800 text-base leading-tight group-hover:text-blue-700 transition-colors">{{ $jadwal->mata_pelajaran }}</h4>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-black uppercase rounded-md border border-blue-100">
                                    {{ $jadwal->kelas }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-chevron-right text-slate-300"></i>
                    </div>
                </div>
            @empty
                <div class="py-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                        <i class="fas fa-calendar-times text-4xl"></i>
                    </div>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada beban mengajar yang terdaftar</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
