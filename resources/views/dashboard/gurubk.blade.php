@extends('layout.app')

@section('title', 'Dashboard Guru BK')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                <i class="fas fa-envelope-open-text fa-2x"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Izin Menunggu</p>
                <p class="text-2xl font-semibold text-gray-700">5</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Selamat Datang, {{ auth()->user()->fullname }}</h2>
    <p class="text-gray-600">Anda login sebagai Guru BK. Anda dapat melihat laporan absensi siswa dan menyetujui izin siswa.</p>
</div>
@endsection
