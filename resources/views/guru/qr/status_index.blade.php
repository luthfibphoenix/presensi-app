@extends('layout.app')

@section('title', 'Status Kehadiran')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Pilih Jadwal Kelas</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($jadwals as $jadwal)
        <a href="{{ route('guru.qr.status', $jadwal->id) }}" class="block p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-300 transition duration-150">
            <h4 class="font-bold text-gray-800">{{ $jadwal->mata_pelajaran }}</h4>
            <p class="text-sm text-gray-600 mb-2">Kelas: {{ $jadwal->kelas }}</p>
            <div class="flex items-center text-xs text-gray-500">
                <i class="fas fa-clock mr-1"></i> {{ $jadwal->hari }}, {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}
            </div>
        </a>
        @empty
        <div class="col-span-full p-4 border rounded-lg text-center text-gray-500 bg-gray-50">
            Anda belum memiliki jadwal mengajar.
        </div>
        @endforelse
    </div>
</div>
@endsection
