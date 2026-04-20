@extends('layout.app')
@section('title', 'Hasil Absen')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="w-full max-w-sm mx-auto text-center">
        @if($status === 'success')
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
            <i class="fas fa-check-circle text-green-500 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Absen Berhasil!</h2>
        <p class="text-gray-500 mb-1">{{ $message }}</p>
        @isset($nama)<p class="font-semibold text-blue-600 mt-1">{{ $nama }}</p>@endisset
        @isset($kelas)<p class="text-sm text-gray-400">Kelas {{ $kelas }}</p>@endisset

        @elseif($status === 'info')
        <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-info-circle text-blue-400 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Sudah Absen</h2>
        <p class="text-gray-500">{{ $message }}</p>

        @elseif($status === 'expired')
        <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-hourglass-end text-yellow-400 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">QR Kadaluarsa</h2>
        <p class="text-gray-500">{{ $message }}</p>

        @else
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-times-circle text-red-400 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Gagal</h2>
        <p class="text-gray-500">{{ $message }}</p>
        @endif

        <div class="mt-8">
            <a href="{{ route('presensi.scan') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow transition">
                <i class="fas fa-qrcode"></i> Scan Lagi
            </a>
        </div>
    </div>
</div>
@endsection
