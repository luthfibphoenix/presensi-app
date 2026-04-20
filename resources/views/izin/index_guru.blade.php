@extends('layout.app')

@section('title', 'Approval Izin')

@section('content')
@php
    $loginRole = session('login_role', 'guru');
    $isPiketMode = $loginRole === 'piket' || str_contains(auth()->user()->position, 'Piket');
@endphp

@if($isPiketMode)
<div class="bg-white rounded-lg shadow p-6 mb-6" x-data="{ 
    showForm: false,
    selectedKelas: '',
    allSiswas: {{ $siswas->map(fn($s) => ['id' => $s->id, 'nama' => $s->nama, 'kelas_id' => $s->kelas_id])->toJson() }}
}">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">Pencatatan Izin Piket</h3>
        <button @click="showForm = !showForm" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition">
            <span x-show="!showForm"><i class="fas fa-plus mr-2"></i> Tambah Data</span>
            <span x-show="showForm"><i class="fas fa-times mr-2"></i> Batal</span>
        </button>
    </div>
    
    <div x-show="showForm" x-collapse x-cloak class="mt-6 pt-6 border-t border-gray-100">
        <form action="{{ route('izin.store.guru') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select x-model="selectedKelas" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelases as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                <select name="siswa_id" :disabled="!selectedKelas" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm disabled:bg-gray-50 disabled:text-gray-400" required>
                    <option value="">Pilih Siswa</option>
                    <template x-for="siswa in allSiswas.filter(s => s.kelas_id == selectedKelas)" :key="siswa.id">
                        <option :value="siswa.id" x-text="siswa.nama"></option>
                    </template>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Keterangan</label>
                <select name="tipe" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="Masuk Telat">Masuk Telat (Terlambat)</option>
                    <option value="Keluar Sekolah">Izin Keluar Sekolah</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan / Catatan</label>
                <input type="text" name="alasan" placeholder="Contoh: Ban bocor / Izin ke Puskesmas" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="lg:col-span-3 flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded font-bold shadow-md transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Daftar Pengajuan Izin Siswa</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($izins as $izin)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal)->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                        {{ $izin->siswa->nama ?? 'Unknown' }}
                        <div class="text-xs text-gray-500">{{ $izin->siswa->kelas->nama_kelas ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                            @if($izin->tipe == 'Masuk Telat') bg-orange-100 text-orange-700
                            @elseif($izin->tipe == 'Keluar Sekolah') bg-purple-100 text-purple-700
                            @elseif($izin->tipe == 'Sakit') bg-red-100 text-red-700
                            @else bg-blue-100 text-blue-700
                            @endif">
                            {{ $izin->tipe }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $izin->alasan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($izin->status == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                        @elseif($izin->status == 'approve')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($izin->status == 'pending')
                        <div class="flex justify-end space-x-2">
                            <form action="{{ route('izin.approve', $izin->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 bg-green-100 hover:bg-green-200 px-2 py-1 rounded">Setujui</button>
                            </form>
                            <form action="{{ route('izin.reject', $izin->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-2 py-1 rounded">Tolak</button>
                            </form>
                        </div>
                        @else
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('izin.print', $izin->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded flex items-center gap-1">
                                <i class="fas fa-print text-xs"></i> Cetak
                            </a>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada pengajuan izin.</td>
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
