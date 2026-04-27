@extends('layout.app')

@section('title', 'Jurnal Mengajar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Daftar Jurnal Mengajar</h2>
        <div class="flex gap-2">
            <a href="{{ route('guru.jurnal.cetak') }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                <i class="fas fa-print mr-1"></i> Cetak Jurnal
            </a>
            <a href="{{ route('presensi.auto_generate') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Buat Jurnal Baru
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jam</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Materi</th>
                    <th class="py-3 px-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($jurnals as $jurnal)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-gray-800">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800">{{ $jurnal->mata_pelajaran }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800">{{ $jurnal->kelas }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800">{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800">{{ Str::limit($jurnal->ringkasan_materi, 50) }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('guru.jurnal.cetak', ['jurnal_id' => $jurnal->id]) }}" target="_blank" class="text-emerald-500 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 p-1.5 rounded" title="Cetak Jurnal">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="{{ route('guru.jurnal.edit', $jurnal->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-1.5 rounded" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('guru.jurnal.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-1.5 rounded" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 px-4 text-center text-gray-500 text-sm">Belum ada jurnal mengajar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
<script>
    // Live Auto-Refresh every 5 seconds
    setInterval(() => {
        // We use fetch to check for updates or just reload the content
        // For simplicity and to ensure all data is fresh, we reload the page
        // but only if the user is not interacting with something (like a delete confirm)
        window.location.reload();
    }, 5000);
</script>
@endpush
@endsection
