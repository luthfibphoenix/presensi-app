@extends('layout.app')

@section('title', 'Pengajuan Izin')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Form Pengajuan Izin</h3>
    
    <form action="{{ route('izin.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Izin</label>
            <input type="date" id="tanggal" name="tanggal" min="{{ date('Y-m-d') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
        </div>
        
        <div class="mb-4">
            <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">Alasan</label>
            <textarea id="alasan" name="alasan" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Sakit / Ada keperluan keluarga" required></textarea>
        </div>
        
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajukan Izin
        </button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Riwayat Pengajuan Izin</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($izins as $izin)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $izin->alasan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($izin->status == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Menunggu</span>
                        @elseif($izin->status == 'approve')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">✅ Disetujui</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">❌ Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada riwayat izin.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($izins->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $izins->links() }}
    </div>
    @endif
</div>
@endsection
