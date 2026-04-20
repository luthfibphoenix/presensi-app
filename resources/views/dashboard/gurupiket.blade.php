@extends('layout.app')

@section('title', 'Dashboard Guru Piket')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <i class="fas fa-calendar-check fa-2x"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Jadwal Aktif</p>
                <p class="text-2xl font-semibold text-gray-700">-</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Selamat Datang, {{ auth()->user()->fullname }}</h2>
    <p class="text-gray-600 mb-6">Anda login sebagai Guru Piket. Anda dapat memantau kehadiran siswa di seluruh kelas dan membantu proses absensi jika diperlukan.</p>
    
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('izin.guru') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold shadow-md transition flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Catat Izin/Telat Siswa
        </a>
        <a href="{{ route('laporan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-bold transition flex items-center gap-2">
            <i class="fas fa-file-invoice"></i> Rekap Presensi
        </a>
    </div>
</div>
@endsection
