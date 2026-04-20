@extends('layout.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <i class="fas fa-calendar-check fa-2x"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Jadwal Hari Ini</p>
                <p class="text-2xl font-semibold text-gray-700">3 Kelas</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Selamat Datang, {{ auth()->user()->fullname }}</h2>
    <p class="text-gray-600">Anda login sebagai Guru. Anda dapat mengelola jadwal kelas Anda dan membuat sesi QR presensi.</p>
    
    <div class="mt-6 flex space-x-4">
        <a href="{{ route('presensi.generate') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Generate QR Code
        </a>
        <a href="{{ route('jadwal.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
            Lihat Jadwal
        </a>
    </div>
</div>
@endsection
