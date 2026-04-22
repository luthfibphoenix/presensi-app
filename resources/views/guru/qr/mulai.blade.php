@extends('layout.app')
@section('title', 'Mulai Kelas — ' . $jadwal->mata_pelajaran)

@section('content')
@php
    $jamMulaiStr   = jamPelajaranToWaktu($jadwal->jam_mulai);
    $jamSelesaiStr = \Carbon\Carbon::createFromFormat('H:i', jamPelajaranToWaktu($jadwal->jam_selesai), 'Asia/Jakarta')->addMinutes(45)->format('H:i');
    $isExpired     = \Carbon\Carbon::now('Asia/Jakarta')->greaterThan($expiredAt);
    $secontsLeft   = max(0, \Carbon\Carbon::now('Asia/Jakarta')->diffInSeconds($expiredAt, false));
@endphp

<div class="h-full overflow-y-auto no-scrollbar pb-24 md:pb-6">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- ── Kolom Kiri: Info Kelas & QR ── --}}
    <div class="space-y-5">

        {{-- Info Kelas --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-blue-500 uppercase tracking-wide mb-1">Sesi Aktif</p>
                    <h2 class="text-xl font-bold text-gray-800">{{ $jadwal->mata_pelajaran }}</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-users text-xs mr-1"></i> Kelas {{ $jadwal->kelas }}
                        &nbsp;·&nbsp;
                        <i class="fas fa-clock text-xs mr-1"></i> {{ $jamMulaiStr }} – {{ $jamSelesaiStr }}
                        &nbsp;·&nbsp;
                        <i class="fas fa-calendar text-xs mr-1"></i> {{ $jadwal->hari }}
                    </p>
                </div>
                <span class="flex-shrink-0 px-3 py-1 rounded-full text-xs font-bold {{ $isExpired ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                    {{ $isExpired ? '⏱ QR Expired' : '🟢 QR Aktif' }}
                </span>
            </div>
        </div>

        {{-- QR Code --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center min-h-[350px] flex flex-col justify-center">
            @if($isPastSchedule)
                <div class="py-8">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-double text-blue-500 text-3xl"></i>
                    </div>
                    <p class="text-gray-800 font-bold mb-1">Jam Pelajaran Telah Selesai</p>
                    <p class="text-gray-400 text-sm mb-6">Silakan kembali ke dashboard untuk melihat ringkasan.</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition">
                        <i class="fas fa-home"></i> Kembali ke Dashboard
                    </a>
                </div>
            @elseif($isWithinSchedule)
                @if($isExpired)
                <div class="py-8">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-qrcode text-red-300 text-3xl"></i>
                    </div>
                    <p class="text-red-600 font-semibold mb-1">QR Code Sudah Kadaluarsa</p>
                    <p class="text-gray-400 text-sm mb-5">Klik Refresh QR untuk membuat token baru.</p>
                    <form action="{{ route('guru.qr.refresh', $qrSession->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow transition">
                            <i class="fas fa-sync-alt"></i> Refresh QR
                        </button>
                    </form>
                </div>
                @else
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-4 font-medium">Scan QR untuk Absensi</p>
                <div id="qrcode" class="flex justify-center mb-4"></div>
                
                {{-- Countdown --}}
                <div class="mt-4 p-3 rounded-xl bg-gray-50 flex items-center justify-center gap-3">
                    <i class="fas fa-sync-alt text-blue-500 animate-spin-slow"></i>
                    <span class="text-sm text-gray-600">Token refresh otomatis dalam: </span>
                    <span id="countdown" class="font-mono font-bold text-lg text-blue-700">15:00</span>
                </div>

                <div class="flex gap-3 mt-4 justify-center">
                    <form action="{{ route('guru.qr.refresh', $qrSession->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition">
                            <i class="fas fa-sync-alt"></i> Manual Refresh
                        </button>
                    </form>
                </div>
                @endif
            @else
                <div class="py-8">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-gray-300 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 font-bold mb-1">Belum Waktunya Mulai</p>
                    <p class="text-gray-400 text-sm px-8">QR Code akan muncul otomatis saat jam pelajaran dimulai.</p>
                </div>
            @endif
        </div>


    </div>

    {{-- ── Kolom Kanan: Daftar Hadir ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Status Kehadiran Siswa</h3>
                <p class="text-xs text-gray-400 mt-0.5" id="last-refresh">Memuat data...</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-700" id="jumlah-hadir">{{ $presensis->whereIn('status', ['Hadir', 'Terlambat'])->count() }}</p>
                <p class="text-xs text-gray-400">/ <span id="total-siswa">{{ $allStudents->count() }}</span> hadir</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto max-h-64 lg:max-h-[calc(100vh-18rem)]">
            <ul id="daftar-hadir" class="divide-y divide-gray-50">
                @foreach($allStudents as $i => $student)
                @php
                    $p = $presensis->get($student->id);
                    $status = $p ? $p->status : 'Belum Absen';
                    
                    $colorClass = 'bg-gray-100 text-gray-500';
                    $icon = 'fas fa-clock';
                    $subtext = 'Belum Absen';

                    if($status == 'Hadir') { 
                        $colorClass = 'bg-green-100 text-green-700'; 
                        $icon = 'fas fa-check-circle';
                        $subtext = 'Hadir Tepat Waktu';
                    } elseif($status == 'Terlambat') { 
                        $colorClass = 'bg-yellow-100 text-yellow-700'; 
                        $icon = 'fas fa-exclamation-circle';
                        $subtext = 'Terlambat ' . ($p->terlambat_menit ?? 0) . ' mnt';
                    } elseif($status == 'Alfa') { 
                        $colorClass = 'bg-red-100 text-red-700'; 
                        $icon = 'fas fa-times-circle';
                        $subtext = 'Tidak Hadir (Alfa)';
                    } elseif($status == 'Izin') { 
                        $colorClass = 'bg-blue-100 text-blue-700'; 
                        $icon = 'fas fa-envelope';
                        $subtext = 'Izin';
                    } elseif($status == 'Sakit') { 
                        $colorClass = 'bg-orange-100 text-orange-700'; 
                        $icon = 'fas fa-heartbeat';
                        $subtext = 'Sakit';
                    }
                @endphp
                <li class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition">
                    <div class="w-8 h-8 rounded-full {{ $colorClass }} flex items-center justify-center font-bold text-xs flex-shrink-0">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate text-sm">{{ $student->nama }}</p>
                        <p class="text-[10px] uppercase font-bold tracking-wider opacity-70">{{ $subtext }}</p>
                    </div>
                    <i class="{{ $icon }} {{ $colorClass }} bg-transparent text-lg opacity-50"></i>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-400 text-right">
            Terakhir refresh: <span id="last-refresh">{{ now()->format('H:i:s') }}</span>
    </div>
</div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
// ── Generate QR ──
@if(!$isExpired)
new QRCode(document.getElementById("qrcode"), {
    text: "{{ $qrUrl }}",
    width: 280, height: 280,
    colorDark: "#1e40af", colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});

// ── Countdown ──
let secondsLeft = {{ $secontsLeft }};
const countdownEl = document.getElementById('countdown');

function updateCountdown() {
    if (secondsLeft <= 0) {
        countdownEl.textContent = '00:00';
        countdownEl.classList.replace('text-blue-700', 'text-red-600');
        // Reload page to show expired state
        setTimeout(() => window.location.reload(), 1000);
        return;
    }
    const minutes = String(Math.floor(secondsLeft / 60)).padStart(2, '0');
    const seconds = String(Math.floor(secondsLeft % 60)).padStart(2, '0');
    countdownEl.textContent = minutes + ':' + seconds;
    
    if (secondsLeft <= 60) countdownEl.classList.replace('text-blue-700', 'text-red-600');
    secondsLeft--;
}
updateCountdown();
setInterval(updateCountdown, 1000);
@endif

// ── Auto-refresh daftar hadir ──
function refreshHadir() {
    fetch("{{ route('guru.qr.status.json', $jadwal->id) }}")
        .then(r => r.json())
        .then(data => {
            document.getElementById('jumlah-hadir').textContent = data.hadir_count;
            document.getElementById('total-siswa').textContent = data.total_count;
            document.getElementById('last-refresh').textContent = 'Terakhir update: ' + new Date().toLocaleTimeString('id-ID') + ' WIB';

            const list = document.getElementById('daftar-hadir');
            list.innerHTML = data.students.map((s, i) => {
                let colorClass = 'bg-gray-100 text-gray-500';
                let icon = 'fas fa-clock';
                let subtext = 'Belum Absen';

                if(s.status == 'Hadir') { 
                    colorClass = 'bg-green-100 text-green-700'; icon = 'fas fa-check-circle'; subtext = 'Hadir Tepat Waktu';
                } else if(s.status == 'Terlambat') { 
                    colorClass = 'bg-yellow-100 text-yellow-700'; icon = 'fas fa-exclamation-circle'; subtext = 'Terlambat ' + (s.terlambat_menit || 0) + ' mnt';
                } else if(s.status == 'Alfa') { 
                    colorClass = 'bg-red-100 text-red-700'; icon = 'fas fa-times-circle'; subtext = 'Tidak Hadir (Alfa)';
                } else if(s.status == 'Izin') { 
                    colorClass = 'bg-blue-100 text-blue-700'; icon = 'fas fa-envelope'; subtext = 'Izin';
                } else if(s.status == 'Sakit') { 
                    colorClass = 'bg-orange-100 text-orange-700'; icon = 'fas fa-heartbeat'; subtext = 'Sakit';
                }

                return `
                <li class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition">
                    <div class="w-8 h-8 rounded-full ${colorClass} flex items-center justify-center font-bold text-xs flex-shrink-0">
                        ${i + 1}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate text-sm">${s.nama}</p>
                        <p class="text-[10px] uppercase font-bold tracking-wider opacity-70">${subtext}</p>
                    </div>
                    <i class="${icon} ${colorClass} bg-transparent text-lg opacity-50"></i>
                </li>`;
            }).join('');
        })
        .catch(console.error);
}

setInterval(refreshHadir, 10000);
refreshHadir();
</script>
@endpush
@endsection
