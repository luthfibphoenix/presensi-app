@extends('layout.app')

@section('title', 'Generate QR Presensi')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Sesi Presensi Baru</h3>
    
    <form action="{{ route('presensi.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="jadwal_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Jadwal Kelas</label>
            <select id="jadwal_id" name="jadwal_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>
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
    <h3 class="text-lg font-medium text-gray-900 mb-4">Sesi Presensi Aktif</h3>
    <p class="mb-4 text-gray-600">Minta siswa Anda untuk melakukan scan QR Code di bawah ini menggunakan portal siswa.</p>
    
    <!-- Dummy QR Code UI, in real app generate with library or show the token string as a QR -->
    <div class="mx-auto w-64 h-64 border-4 border-blue-900 p-2 flex items-center justify-center bg-gray-50 mb-4">
        <!-- Display token for manual testing since this is a prototype without a QR generator library server-side -->
        <div class="break-all text-sm font-mono text-center">
            @php 
                $message = session('success');
                $token = explode('token: ', $message)[1] ?? 'TOKEN';
            @endphp
            {{ $token }}
            <br><br>
            <span class="text-xs text-gray-400">(Tampilkan QR sungguhan di sini menggunakan library QR code)</span>
        </div>
    </div>
    
    <p class="text-sm font-bold text-red-600">Sesi ini berlaku selama 2 jam.</p>
</div>
@endif
@endsection
