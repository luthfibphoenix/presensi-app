@extends('layout.app')

@section('title', 'Laporan Presensi')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Data Laporan Absensi Seluruh Siswa</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($presensis as $presensi)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $presensi->siswa->nama ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $presensi->jadwal->kelas ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($presensi->status == 'Hadir')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $presensi->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Data laporan kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($presensis->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $presensis->links() }}
    </div>
    @endif
</div>
@endsection
