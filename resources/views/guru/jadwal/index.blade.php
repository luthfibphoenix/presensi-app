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
<div x-data="{ 
    showQrModal: false, 
    showChoiceModal: false,
    loading: false,
    qrData: null,
    multipleJadwals: [],
    timer: '15:00',
    timerColor: 'text-emerald-500',
    interval: null,

    async generateQR(jadwalId = null) {
        this.loading = true;
        this.showChoiceModal = false;
        try {
            const response = await fetch('/dashboard/generate-qr', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.content || '{{ csrf_token() }}',
                    'ngrok-skip-browser-warning': 'true'
                },
                body: JSON.stringify({ jadwal_id: jadwalId })
            });
            const data = await response.json();
            
            if (data.status === 'success') {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                    return;
                }
                this.qrData = data;
                this.showQrModal = true;
                this.startTimer(data.expired_at);
            } else if (data.status === 'multiple') {
                this.multipleJadwals = data.jadwals;
                this.showChoiceModal = true;
            } else {
                alert(data.message || 'Gagal generate QR Code');
            }
        } catch (e) {
            console.error(e);
            alert('Error: ' + e.message + '\n\nCoba refresh halaman dan ulangi.');
        } finally {
            this.loading = false;
        }
    },

    startTimer(expiryStr) {
        if (this.interval) clearInterval(this.interval);
        const expiry = new Date(expiryStr).getTime();
        
        this.interval = setInterval(() => {
            const now = new Date().getTime();
            const diff = expiry - now;
            
            if (diff <= 0) {
                clearInterval(this.interval);
                this.timer = '00:00';
                this.generateQR(this.qrData.jadwal_id);
                return;
            }
            
            const minutes = Math.floor(diff / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            this.timer = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            
            if (minutes >= 5) {
                this.timerColor = 'text-emerald-500';
            } else if (minutes >= 2) {
                this.timerColor = 'text-amber-500';
            } else {
                this.timerColor = 'text-red-500';
            }
        }, 1000);
    }
}">
<div class="grid gap-4">
    @foreach($jadwals as $jadwal)
    @php
        $jamMulaiStr  = jamPelajaranToWaktu($jadwal->jam_mulai);
        $jamSelesaiStr= \Carbon\Carbon::createFromFormat('H:i', jamPelajaranToWaktu($jadwal->jam_selesai), 'Asia/Jakarta')->addMinutes(45)->format('H:i');
        $isHariIni    = ($jadwal->hari === $hariIni);
        $isWaktunya   = $isHariIni && ($nowTime >= $jamMulaiStr && $nowTime <= $jamSelesaiStr);
        $isAkanMulai  = $isHariIni && ($nowTime >= date('H:i', strtotime($jamMulaiStr . ' -15 minutes')) && $nowTime < $jamMulaiStr);
        $bolehMulai   = true; // Selalu boleh mulai kelas di hari yang sama
    @endphp
    <div class="bg-white rounded-2xl shadow-sm border {{ $isWaktunya ? 'border-blue-300 ring-1 ring-blue-200' : 'border-gray-100' }} overflow-hidden">
        <div class="flex items-stretch">
            <div class="w-1.5 {{ $isWaktunya ? 'bg-green-400' : ($isAkanMulai ? 'bg-yellow-400' : 'bg-gray-200') }} flex-shrink-0"></div>
            <div class="flex-1 p-4 md:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600 text-[10px] font-bold">
                            <i class="far fa-clock"></i> {{ $jamMulaiStr }} – {{ $jamSelesaiStr }} (Jam {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }})
                        </span>
                        @if($isWaktunya)
                        <span class="px-2.5 py-1 rounded-lg bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider animate-pulse">
                            Berlangsung
                        </span>
                        @endif
                    </div>
                    <h3 class="text-base md:text-lg font-black text-gray-800 leading-tight mb-1 truncate">{{ $jadwal->mata_pelajaran }}</h3>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-400 font-medium">
                        <span class="flex items-center gap-1.5"><i class="fas fa-users text-[10px]"></i> Kelas {{ $jadwal->kelas }}</span>
                        <span class="flex items-center gap-1.5"><i class="fas fa-bookmark text-[10px]"></i> Semester {{ $jadwal->semester }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    @if($isWaktunya)
                        @php
                            $jakartaNow = \Carbon\Carbon::now('Asia/Jakarta');
                            $actualEndTime = \Carbon\Carbon::createFromFormat('H:i', $jamSelesaiStr, 'Asia/Jakarta');
                            $timeToAkhiri = (clone $actualEndTime)->subMinutes(30);
                            $bolehAkhiri = $jakartaNow->greaterThanOrEqualTo($timeToAkhiri);
                            $session = \App\Models\QrSession::where('jadwal_id', $jadwal->id)
                                        ->where('tanggal', $jakartaNow->toDateString())
                                        ->orderBy('created_at', 'desc')
                                        ->first();
                        @endphp
                        
                        @if($session)
                        <div class="group relative">
                            <button :disabled="!{{ $bolehAkhiri ? 'true' : 'false' }}" 
                                    @click="{{ $bolehAkhiri ? 'document.getElementById(\'end-form-'.$jadwal->id.'\').submit()' : '' }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-400 text-xs font-bold rounded-xl {{ $bolehAkhiri ? 'hover:bg-red-50 hover:text-red-500 cursor-pointer' : 'cursor-not-allowed' }} transition">
                                <i class="fas fa-power-off"></i> Akhiri Sesi
                            </button>
                            @if(!$bolehAkhiri)
                            <div class="absolute bottom-full right-0 mb-2 hidden group-hover:block z-10">
                                <div class="bg-gray-800 text-white text-[10px] rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                                    Tombol aktif 30 menit sebelum kelas selesai (jam {{ $timeToAkhiri->format('H:i') }})
                                </div>
                            </div>
                            @endif
                            <form id="end-form-{{ $jadwal->id }}" action="{{ route('dashboard.end_session') }}" method="POST" class="hidden">
                                @csrf
                                <input type="hidden" name="session_id" value="{{ $session->id }}">
                            </form>
                        </div>
                        @endif
                    @endif

                    @if($bolehMulai)
                    <button @click="generateQR({{ $jadwal->id }})" :disabled="loading"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md transition whitespace-nowrap disabled:opacity-50">
                        <i class="fas fa-play-circle"></i> {{ $isWaktunya ? 'Mulai / Refresh' : 'Mulai Kelas' }}
                    </button>
                    @else
                    <div class="group relative">
                        <button disabled
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-50 text-gray-300 text-xs font-bold rounded-xl cursor-not-allowed whitespace-nowrap">
                            <i class="fas fa-clock"></i> Mulai Kelas
                        </button>
                        <div class="absolute bottom-full right-0 mb-2 hidden group-hover:block z-10">
                            <div class="bg-gray-800 text-white text-[10px] rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
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

{{-- Modal QR Code --}}
<div x-show="showQrModal" x-transition.opacity class="fixed inset-0 z-[60] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
    <div @click.outside="showQrModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden text-center">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <h3 class="text-xl font-black text-gray-900 mb-1" x-text="qrData?.mapel"></h3>
            <div class="flex items-center justify-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                <span class="text-blue-600" x-text="qrData?.kelas"></span>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span x-text="qrData?.hari"></span>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span x-text="qrData?.jam"></span>
            </div>
        </div>
        <div class="p-8 flex flex-col items-center">
            <div class="bg-white p-4 rounded-3xl shadow-inner border border-gray-100 mb-6 group transition-all duration-500 hover:shadow-xl overflow-hidden" x-html="qrData?.qr_code">
            </div>
            
            <div class="flex items-center gap-2 bg-gray-50 px-6 py-3 rounded-2xl mb-6 font-black border-2 border-gray-100" :class="timerColor">
                <i class="fas fa-clock"></i>
                <span class="text-2xl tracking-tighter font-mono" x-text="timer"></span>
            </div>

            <p class="text-xs text-gray-400 px-4 leading-relaxed">
                Tunjukkan QR Code ini kepada siswa untuk melakukan scan presensi.
            </p>
        </div>
        <div class="p-6 bg-gray-50 flex justify-center">
            <button @click="showQrModal = false" class="bg-white text-gray-800 border border-gray-200 px-8 py-2.5 rounded-xl font-bold hover:bg-gray-100 transition-all">Tutup</button>
        </div>
    </div>
</div>
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
