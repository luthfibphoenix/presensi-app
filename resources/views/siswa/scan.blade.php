@extends('layout.app')
@section('title', 'Scan Absen')

@section('content')
<div class="max-w-md mx-auto">

    {{-- Header --}}
    <div class="text-center mb-6">
        <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
            <i class="fas fa-qrcode text-white text-2xl"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800">Scan QR Presensi</h2>
        <p class="text-gray-400 text-sm mt-1">Arahkan kamera ke QR Code yang ditampilkan guru</p>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm flex items-center gap-2">
        <i class="fas fa-check-circle flex-shrink-0"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center gap-2">
        <i class="fas fa-times-circle flex-shrink-0"></i> {{ session('error') }}
    </div>
    @endif
    @if(session('info'))
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-blue-700 text-sm flex items-center gap-2">
        <i class="fas fa-info-circle flex-shrink-0"></i> {{ session('info') }}
    </div>
    @endif

    {{-- Scanner Container --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div id="reader" class="w-full"></div>

        <div id="scan-status" class="p-4 text-center text-sm text-gray-400 flex items-center justify-center gap-2">
            <span class="inline-block w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            Kamera aktif — arahkan ke QR Code guru
        </div>
    </div>

    {{-- Manual URL input fallback --}}
    <div class="mt-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
        <p class="text-xs text-gray-500 text-center mb-2">Tidak bisa scan? Minta guru tunjukkan URL token</p>
        <form id="manual-form" action="" method="GET" class="flex gap-2">
            <input type="text" id="manual-token" placeholder="Masukkan token dari guru..."
                   class="flex-1 text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-400 outline-none">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                Go
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
const html5QrCode = new Html5Qrcode("reader");
let scanning = false;

const config = {
    fps: 10,
    qrbox: { width: 280, height: 280 },
    aspectRatio: 1.0,
    rememberLastUsedCamera: true,
};

function onScanSuccess(decodedText) {
    if (scanning) return;
    scanning = true;

    // Stop camera
    html5QrCode.stop();

    // Update status
    document.getElementById('scan-status').innerHTML =
        '<span class="inline-block w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span> QR ditemukan, mengalihkan...';

    // Extract token from URL or use text directly
    let url = decodedText;
    if (!decodedText.startsWith('http')) {
        url = '/siswa/scan/' + decodedText;
    }

    // Redirect to scan route
    window.location.href = url;
}

function onScanFailure(error) {
    // Ignore — just means no QR in frame yet
}

// Start camera
Html5Qrcode.getCameras().then(devices => {
    if (devices && devices.length) {
        // Prefer rear camera on mobile
        const rearCam = devices.find(d =>
            d.label.toLowerCase().includes('back') ||
            d.label.toLowerCase().includes('rear') ||
            d.label.toLowerCase().includes('environment')
        );
        const camId = rearCam ? rearCam.id : devices[devices.length - 1].id;
        html5QrCode.start(camId, config, onScanSuccess, onScanFailure)
            .catch(err => {
                // Try with facingMode as fallback
                html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
                    .catch(e2 => {
                        document.getElementById('scan-status').innerHTML =
                            '<span class="text-red-500"><i class="fas fa-exclamation-triangle mr-1"></i>Kamera tidak dapat diakses. Izinkan akses kamera di browser.</span>';
                    });
            });
    }
}).catch(err => {
    // Try environment camera directly
    html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
        .catch(e => {
            document.getElementById('scan-status').innerHTML =
                '<span class="text-red-500"><i class="fas fa-exclamation-triangle mr-1"></i>Gagal mengakses kamera.</span>';
        });
});

// Manual form
document.getElementById('manual-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const token = document.getElementById('manual-token').value.trim();
    if (token) {
        window.location.href = '/siswa/scan/' + token;
    }
});
</script>
@endpush
@endsection
