@extends('layout.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-500 mr-4">
                <i class="fas fa-chalkboard-teacher fa-2x"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Siswa Wali</p>
                <p class="text-2xl font-semibold text-gray-700">32 Anak</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Selamat Datang, {{ auth()->user()->fullname }}</h2>
    <p class="text-gray-600">Anda memiliki peran tambahan sebagai Wali Kelas. Anda dapat memantau presensi kelas Anda secara khusus.</p>
</div>
@endsection
