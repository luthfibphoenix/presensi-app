@extends('layout.app')
@section('title', 'Mulai Kelas — ' . $jadwal->mata_pelajaran)

@section('content')
@php
    $jamMulaiStr   = $jamMap[$jadwal->jam_mulai]  ?? sprintf('%02d:00', 6 + $jadwal->jam_mulai);
    $jamSelesaiStr = $jamMap[$jadwal->jam_selesai] ?? sprintf('%02d:00', 6 + $jadwal->jam_selesai);
    $isExpired     = \Carbon\Carbon::now()->greaterThan($expiredAt);
    $secontsLeft   = max(0, \Carbon\Carbon::now()->diffInSeconds($expiredAt, false));
@endphp

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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
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
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-4 font-medium">Minta siswa scan QR ini</p>
            <div id="qrcode" class="flex justify-center mb-4"></div>
            
            {{-- Countdown --}}
            <div class="mt-4 p-3 rounded-xl bg-gray-50 flex items-center justify-center gap-3">
                <i class="fas fa-hourglass-half text-yellow-500"></i>
                <span class="text-sm text-gray-600">QR berlaku selama: </span>
                <span id="countdown" class="font-mono font-bold text-lg text-blue-700">15:00</span>
            </div>

            <div class="flex gap-3 mt-4 justify-center">
                <form action="{{ route('guru.qr.refresh', $qrSession->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition">
                        <i class="fas fa-sync-alt"></i> Refresh QR
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- Tombol Akhiri Kelas --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-5">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="font-semibold text-gray-700">Selesai mengajar?</p>
                    <p class="text-sm text-gray-400">Akhiri kelas untuk menutup sesi presensi.</p>
                </div>
                <form action="{{ route('guru.qr.end', $qrSession->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin mengakhiri kelas?')">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl shadow transition">
                        <i class="fas fa-stop-circle"></i> Akhiri Kelas
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Kolom Kanan: Daftar Hadir ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Daftar Siswa Hadir</h3>
                <p class="text-xs text-gray-400 mt-0.5">Auto-refresh setiap 10 detik</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-700" id="jumlah-hadir">{{ $presensis->count() }}</p>
                <p class="text-xs text-gray-400">/ <span id="total-siswa">{{ $totalSiswa ?: '?' }}</span> siswa</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto max-h-[calc(100vh-20rem)]">
            <ul id="daftar-hadir" class="divide-y divide-gray-50">
                @forelse($presensis as $i => $p)
                <li class="flex items-center gap-3 px-6 py-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs flex-shrink-0">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate">{{ $p->nama_siswa }}</p>
                        <p class="text-xs text-gray-400">{{ $p->status }} · {{ $p->tanggal }}</p>
                    </div>
                    @if($p->status == 'Hadir')
                        <i class="fas fa-check-circle text-green-400 flex-shrink-0"></i>
                    @elseif($p->status == 'Izin')
                        <i class="fas fa-envelope text-blue-400 flex-shrink-0"></i>
                    @elseif($p->status == 'Sakit')
                        <i class="fas fa-medkit text-red-400 flex-shrink-0"></i>
                    @else
                        <i class="fas fa-info-circle text-gray-400 flex-shrink-0"></i>
                    @endif
                </li>
                @empty
                <li id="empty-state" class="px-6 py-12 text-center">
                    <i class="fas fa-user-clock text-gray-200 text-4xl mb-2"></i>
                    <p class="text-gray-400 text-sm">Belum ada siswa yang hadir</p>
                </li>
                @endforelse
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
    const m = Math.floor(secondsLeft / 60);
    const s = secondsLeft % 60;
    countdownEl.textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
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
            document.getElementById('jumlah-hadir').textContent = data.hadir;
            if (data.total_siswa > 0) document.getElementById('total-siswa').textContent = data.total_siswa;
            document.getElementById('last-refresh').textContent = new Date().toLocaleTimeString('id-ID');

            const list = document.getElementById('daftar-hadir');
            if (data.presensis.length === 0) {
                list.innerHTML = `<li id="empty-state" class="px-6 py-12 text-center"><i class="fas fa-user-clock text-gray-200 text-4xl mb-2"></i><p class="text-gray-400 text-sm">Belum ada siswa yang hadir</p></li>`;
            } else {
                list.innerHTML = data.presensis.map((p, i) => {
                    let icon = '<i class="fas fa-check-circle text-green-400 flex-shrink-0"></i>';
                    if(p.status == 'Izin') icon = '<i class="fas fa-envelope text-blue-400 flex-shrink-0"></i>';
                    else if(p.status == 'Sakit') icon = '<i class="fas fa-medkit text-red-400 flex-shrink-0"></i>';
                    
                    return `
                    <li class="flex items-center gap-3 px-6 py-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs flex-shrink-0">${i+1}</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 truncate">${p.nama_siswa}</p>
                            <p class="text-xs text-gray-400">${p.status} · ${p.tanggal}</p>
                        </div>
                        ${icon}
                    </li>`;
                }).join('');
            }
        })
        .catch(console.error);
}
setInterval(refreshHadir, 10000);
</script>
@endpush
@endsection
