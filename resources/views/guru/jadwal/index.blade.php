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

@if($jadwals->isEmpty())
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-calendar-times text-blue-400 text-2xl"></i>
    </div>
    <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak ada jadwal hari ini</h3>
    <p class="text-gray-400 text-sm">Anda tidak memiliki jadwal mengajar pada hari {{ $hariIni }}.</p>
    <a href="{{ route('jadwal.semua') }}" class="mt-4 inline-block text-blue-500 text-sm hover:underline">Lihat semua jadwal →</a>
</div>
@else
<div class="grid gap-4">
    @foreach($jadwals as $jadwal)
    @php
        $jamMulaiStr  = jamPelajaranToWaktu($jadwal->jam_mulai);
        $jamSelesaiStr= \Carbon\Carbon::createFromFormat('H:i', jamPelajaranToWaktu($jadwal->jam_selesai), 'Asia/Jakarta')->addMinutes(45)->format('H:i');
        $isHariIni    = ($jadwal->hari === $hariIni);
        $isWaktunya   = $isHariIni && ($nowTime >= $jamMulaiStr && $nowTime <= $jamSelesaiStr);
        // Allow 15 min before
        $isAkanMulai  = $isHariIni && ($nowTime >= date('H:i', strtotime($jamMulaiStr . ' -15 minutes')) && $nowTime < $jamMulaiStr);
        $bolehMulai   = $isWaktunya || $isAkanMulai;
    @endphp
    <div class="bg-white rounded-2xl shadow-sm border {{ $isWaktunya ? 'border-blue-300 ring-1 ring-blue-200' : 'border-gray-100' }} overflow-hidden">
        <div class="flex items-stretch">
            {{-- Color bar --}}
            <div class="w-1.5 {{ $isWaktunya ? 'bg-green-400' : ($isAkanMulai ? 'bg-yellow-400' : 'bg-gray-200') }} flex-shrink-0"></div>

            <div class="flex-1 p-5 flex items-center justify-between gap-4">
                <div class="flex-1">
                    {{-- Jam badge --}}
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $isWaktunya ? 'bg-green-100 text-green-700' : ($isAkanMulai ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500') }}">
                            <i class="fas fa-clock text-[10px]"></i>
                            {{ $jamMulaiStr }} – {{ $jamSelesaiStr }}
                            (Jam {{ $jadwal->jam_mulai }}–{{ $jadwal->jam_selesai }})
                        </span>
                        @if($isWaktunya)
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-green-500 text-white animate-pulse">BERLANGSUNG</span>
                        @elseif($isAkanMulai)
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-yellow-400 text-yellow-900">SEGERA MULAI</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $jadwal->mata_pelajaran }}</h3>
                    <p class="text-gray-500 text-sm mt-0.5">
                        <i class="fas fa-users text-xs mr-1"></i> Kelas {{ $jadwal->kelas }}
                        &nbsp;·&nbsp;
                        <i class="fas fa-book text-xs mr-1"></i> Semester {{ $jadwal->semester }}
                    </p>
                </div>

                {{-- Tombol Mulai Kelas & Akhiri Sesi --}}
                <div class="flex-shrink-0 flex items-center gap-2">
                    @if($isWaktunya)
                        @php
                            // Gunakan timezone Jakarta secara konsisten
                            $jakartaNow = \Carbon\Carbon::now('Asia/Jakarta');
                            
                             // Jam selesai adalah jam mulai jam terakhir + 45 menit (sudah dihitung di $jamSelesaiStr)
                             $actualEndTime = \Carbon\Carbon::createFromFormat('H:i', $jamSelesaiStr, 'Asia/Jakarta');
                            $timeToAkhiri = (clone $actualEndTime)->subMinutes(30);
                            $bolehAkhiri = $jakartaNow->greaterThanOrEqualTo($timeToAkhiri);
                            
                            // Cari sesi QR hari ini untuk jadwal ini (walaupun sudah expired tokennya)
                            $session = \App\Models\QrSession::where('jadwal_id', $jadwal->id)
                                        ->where('tanggal', $jakartaNow->toDateString())
                                        ->orderBy('created_at', 'desc')
                                        ->first();
                        @endphp

                        @if($session)
                            <div class="group relative">
                                @if($bolehAkhiri)
                                    <form action="{{ route('dashboard.end_session') }}" method="POST" onsubmit="return confirm('Akhiri sesi kelas sekarang? Siswa yang belum absen akan otomatis dicatat Alfa.')">
                                        @csrf
                                        <input type="hidden" name="session_id" value="{{ $session->id }}">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl shadow transition">
                                            <i class="fas fa-power-off"></i> Akhiri Sesi
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-400 text-sm font-semibold rounded-xl cursor-not-allowed">
                                        <i class="fas fa-power-off"></i> Akhiri Sesi
                                    </button>
                                    <div class="absolute bottom-full right-0 mb-2 hidden group-hover:block z-10">
                                        <div class="bg-gray-800 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                                            Tombol aktif 30 menit sebelum kelas selesai (jam {{ $timeToAkhiri->format('H:i') }})
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif

                    @if($bolehMulai)
                    <form action="{{ route('guru.qr.generate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow transition">
                            <i class="fas fa-play-circle"></i> {{ $isWaktunya ? 'Mulai / Refresh' : 'Mulai Kelas' }}
                        </button>
                    </form>
                    @else
                    <div class="group relative">
                        <button disabled
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-400 text-sm font-semibold rounded-xl cursor-not-allowed">
                            <i class="fas fa-clock"></i> Mulai Kelas
                        </button>
                        <div class="absolute bottom-full right-0 mb-2 hidden group-hover:block z-10">
                            <div class="bg-gray-800 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                                Belum waktunya — Mulai jam {{ $jamMulaiStr }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@push('scripts')
<script>
// Update jam sekarang setiap detik
function updateTime() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    document.getElementById('jam-sekarang').textContent = h + ':' + m;
}
setInterval(updateTime, 1000);
</script>
@endpush
@endsection
