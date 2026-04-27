@extends('layout.app')

@section('title', 'Status Kehadiran Kelas')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Daftar Siswa Hadir</h3>
            <p class="text-sm text-gray-500">
                Mata Pelajaran: <strong>{{ $jadwal->mata_pelajaran }}</strong> | 
                Kelas: <strong>{{ $jadwal->kelas }}</strong> | 
                Tanggal: <strong>{{ date('d M Y') }}</strong>
            </p>
        </div>
        <button onclick="window.location.reload();" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
            <i class="fas fa-sync-alt mr-2"></i> Refresh
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Absen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($presensis as $index => $presensi)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ optional($presensi->siswa)->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($presensi->created_at)->format('H:i:s') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $colorClass = 'bg-emerald-100 text-emerald-800';
                            $statusText = $presensi->status;
                            
                            if($presensi->status == 'Terlambat') {
                                $colorClass = 'bg-amber-100 text-amber-800';
                                $statusText .= " (" . ($presensi->terlambat_menit ?? 0) . " menit)";
                            } elseif($presensi->status == 'Alfa') {
                                $colorClass = 'bg-red-100 text-red-800';
                            } elseif(in_array($presensi->status, ['Izin', 'Sakit'])) {
                                $colorClass = 'bg-blue-100 text-blue-800';
                            }
                        @endphp
                        <span class="px-3 py-1 inline-flex text-[10px] uppercase tracking-wider font-black rounded-lg {{ $colorClass }}">
                            {{ $statusText }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center py-10">
                        <i class="fas fa-users-slash text-gray-300 text-4xl mb-3 block"></i>
                        Belum ada siswa yang absen hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <p class="text-sm text-gray-600">Total Hadir: <span class="font-bold text-gray-900">{{ count($presensis) }} Siswa</span></p>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh dihapus
</script>
@endpush

@endsection
