@extends('layout.app')

@section('title', 'Jadwal Mengajar')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Daftar Jadwal Anda</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($jadwals as $jadwal)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $jadwal->hari }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $jadwal->mata_pelajaran }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $jadwal->kelas }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->semester }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <form action="{{ route('guru.qr.generate') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                <i class="fas fa-qrcode mr-1.5"></i> Generate QR
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada jadwal mengajar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($jadwals->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $jadwals->links() }}
    </div>
    @endif
</div>
@endsection
