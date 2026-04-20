@extends('layout.app')

@section('title', 'Generate QR Presensi')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Sesi Presensi Baru</h3>
    
    <form action="{{ route('guru.qr.generate') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="jadwal_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Jadwal Kelas</label>
            <select id="jadwal_id" name="jadwal_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border" required>
                <option value="">-- Pilih Jadwal --</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}">{{ $jadwal->kelas }} - {{ $jadwal->mata_pelajaran }} ({{ $jadwal->hari }}, {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }})</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Generate QR Code
        </button>
    </form>
</div>

@if(session('success'))
<div class="bg-white rounded-lg shadow overflow-hidden p-6 text-center">
    <h3 class="text-xl font-bold text-gray-900 mb-2">QR Code Presensi Aktif</h3>
    <p class="mb-6 text-gray-600">Minta siswa Anda untuk memindai QR Code di bawah ini.</p>
    
    <!-- Div for QRCode.js to render the QR Code -->
    <div id="qrcode" class="flex justify-center mb-6"></div>
    
    <p class="text-md font-bold text-red-600 mb-4"><i class="fas fa-clock mr-1"></i> QR Code ini hanya berlaku selama 15 menit.</p>
    
    <div class="mt-4">
        <a href="{{ route('guru.qr.status', session('jadwal_id')) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
            <i class="fas fa-users mr-2"></i> Pantau Siswa Hadir
        </a>
    </div>
</div>

@push('scripts')
<!-- Load QRCode.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Text/URL to encode inside the QR
        var qrUrl = "{{ session('url') }}";
        
        // Generate QR code
        new QRCode(document.getElementById("qrcode"), {
            text: qrUrl,
            width: 300,
            height: 300,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });
</script>
@endpush
@endif

@endsection
