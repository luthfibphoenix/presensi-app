@extends('layout.app')
@section('title', 'Jadwal Hari Ini')

@section('content')
@php
    $hariOrder = ['Senin'=>1,'Selasa'=>2,'Rabu'=>3,'Kamis'=>4,'Jumat'=>5,'Sabtu'=>6];
    $todayDayName = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');
    $todayDayName = ucfirst(strtolower($todayDayName));
@endphp

{{-- Tab navigasi --}}
<div class="flex gap-2 mb-6">
    <a href="{{ route('jadwal.hari.ini') }}"
       class="px-4 py-2 rounded-lg font-medium text-sm {{ request()->routeIs('jadwal.hari.ini') ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        <i class="fas fa-calendar-day mr-1"></i> Jadwal Hari Ini
    </a>
    <a href="{{ route('jadwal.semua') }}"
       class="px-4 py-2 rounded-lg font-medium text-sm {{ request()->routeIs('jadwal.semua') ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        <i class="fas fa-calendar-week mr-1"></i> Semua Jadwal
    </a>
</div>

{{-- Header info hari --}}
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800">
            Jadwal {{ $hariIni }}, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}
        </h2>
        <p class="text-sm text-gray-500 mt-0.5">Jam sekarang: <span id="jam-sekarang" class="font-mono font-semibold text-blue-600">{{ $nowTime }}</span></p>
    </div>
</div>

{{-- Bagian Atas: Tombol Mulai Sesi Baru --}}
@if($jadwals->isEmpty())
    {{-- Versi BESAR (Hero) - Jika belum ada sesi --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8 text-center bg-gradient-to-br from-white to-blue-50/30">
        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
            <i class="fas fa-qrcode text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-black text-slate-800 mb-1">Mulai Presensi Baru</h3>
        <p class="text-slate-400 text-xs mb-6">Pilih kelas dan mapel untuk membuat QR Code baru</p>
        
        <a href="{{ route('presensi.generate.view') }}" 
           class="inline-flex items-center gap-3 px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
            <i class="fas fa-plus-circle text-base"></i> Buat Sesi Sekarang
        </a>
    </div>
@else
    {{-- Versi KECIL (Compact) - Jika sudah ada sesi aktif --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-8 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-plus text-sm"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-slate-800 leading-none">Ada Sesi Berjalan</h3>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Ingin memulai kelas lain?</p>
            </div>
        </div>
        <a href="{{ route('presensi.generate.view') }}" 
           class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-md transition-all active:scale-95 uppercase tracking-widest text-[8px]">
            Buat Sesi Baru
        </a>
    </div>
@endif

{{-- Bagian Bawah: Daftar Sesi Aktif --}}
<div class="space-y-4">
    <div class="flex items-center gap-3 px-1">
        <div class="h-1 w-8 bg-blue-500 rounded-full"></div>
        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">Sesi Berjalan Hari Ini</h4>
    </div>

    @if($jadwals->isEmpty())
        <div class="bg-slate-50/50 border-2 border-dashed border-slate-200 rounded-[2rem] p-12 text-center">
            <p class="text-slate-400 text-sm font-medium italic">Belum ada sesi kelas yang dimulai hari ini.</p>
        </div>
    @else
        <div class="grid gap-3 md:gap-4">
            @foreach($jadwals as $jadwal)
                @php
                    $session = $jadwal->qrSessions->first();
                @endphp
                <div class="flex items-stretch gap-2">
                    <a href="{{ route('guru.mulai.kelas', $session->id) }}" 
                       class="group bg-white rounded-2xl border border-slate-100 p-4 md:p-5 shadow-sm hover:shadow-md hover:border-blue-200 transition-all flex-1 flex items-center justify-between gap-3 min-w-0">
                        <div class="flex items-center gap-3 md:gap-4 min-w-0">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-slate-50 group-hover:bg-blue-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:text-blue-500 transition-colors flex-shrink-0">
                                <i class="fas fa-chalkboard-teacher text-lg md:text-xl"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-black text-slate-800 group-hover:text-blue-600 transition-colors text-sm md:text-base truncate">{{ $jadwal->mata_pelajaran }}</h3>
                                <div class="flex flex-wrap items-center gap-x-2 gap-y-0.5 mt-0.5 text-[10px] md:text-[11px] font-bold text-slate-400">
                                    <span class="flex items-center gap-1"><i class="fas fa-users"></i> {{ $jadwal->kelas }}</span>
                                    <span class="hidden md:inline w-1 h-1 rounded-full bg-slate-200"></span>
                                    <span class="flex items-center gap-1"><i class="far fa-clock"></i> {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="hidden sm:inline-block px-3 py-1 bg-green-100 text-green-600 text-[10px] font-black uppercase rounded-lg">Aktif</span>
                            <i class="fas fa-chevron-right text-slate-300 group-hover:translate-x-1 transition-transform text-xs"></i>
                        </div>
                    </a>

                    {{-- Tombol Hentikan Sesi --}}
                    <form action="{{ route('guru.qr.end', $session->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghentikan sesi presensi ini?')" class="flex">
                        @csrf
                        <button type="submit" 
                                class="w-12 md:w-14 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-2xl border border-red-100 transition-all flex items-center justify-center shadow-sm active:scale-90 flex-shrink-0"
                                title="Hentikan Sesi">
                            <i class="fas fa-power-off text-sm md:text-base"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
// Update jam sekarang setiap detik
function updateTime() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    if(document.getElementById('jam-sekarang')) {
        document.getElementById('jam-sekarang').textContent = h + ':' + m;
    }
}
setInterval(updateTime, 1000);
</script>
@endpush
@endsection
