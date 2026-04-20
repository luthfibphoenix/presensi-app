@extends('layout.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total Hadir</p>
                <p class="text-2xl font-semibold text-gray-700">45</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-500 mr-4">
                <i class="fas fa-times-circle fa-2x"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total Alpa</p>
                <p class="text-2xl font-semibold text-gray-700">0</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Halo, {{ auth('siswa')->user()->nama }}</h2>
    <p class="text-gray-600">Gunakan menu <strong>Scan QR Presensi</strong> untuk melakukan absensi saat kelas dimulai.</p>
    
    <div class="mt-6">
        <a href="{{ route('presensi.scan') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
            <i class="fas fa-camera mr-2"></i> Scan QR Sekarang
        </a>
    </div>
</div>
@endsection
