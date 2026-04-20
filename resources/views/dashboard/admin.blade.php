@extends('layout.app')

@section('title', 'Dashboard Administrator')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <i class="fas fa-users fa-2x"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total Pengguna</p>
                <p class="text-2xl font-semibold text-gray-700">120</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                <i class="fas fa-user-graduate fa-2x"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total Siswa</p>
                <p class="text-2xl font-semibold text-gray-700">850</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Selamat Datang, {{ auth()->user()->fullname }}</h2>
    <p class="text-gray-600">Anda login sebagai Administrator dengan akses penuh ke seluruh sistem.</p>
</div>
@endsection
