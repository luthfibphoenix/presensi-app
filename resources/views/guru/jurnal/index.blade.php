@extends('layout.app')

@section('title', 'Jurnal Mengajar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6" x-data="{ showDeleteModal: false, confirmCheck: false }">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Jurnal Mengajar</h2>
            <p class="text-xs text-gray-500 mt-1">Riwayat materi dan presensi yang Anda ajarkan.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @if($jurnals->isNotEmpty())
            <button @click="showDeleteModal = true" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition-all border border-red-100">
                <i class="fas fa-trash-alt mr-1"></i> Hapus Semua
            </button>
            @endif
            <a href="{{ route('guru.jurnal.cetak') }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm shadow-indigo-100">
                <i class="fas fa-print mr-1"></i> Cetak Jurnal
            </a>
            <a href="{{ route('presensi.auto_generate') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm shadow-blue-100">
                <i class="fas fa-plus mr-1"></i> Buat Jurnal Baru
            </a>
        </div>

        {{-- Modal Konfirmasi Hapus Semua --}}
        <div x-show="showDeleteModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div @click.outside="showDeleteModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-in zoom-in duration-300">
                <div class="p-8 text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500 border-4 border-red-100 animate-pulse">
                        <i class="fas fa-exclamation-triangle text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-2">Hapus Semua Jurnal?</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        Tindakan ini akan menghapus **seluruh** riwayat jurnal dan data presensi Anda secara permanen. Data yang sudah dihapus tidak dapat dikembalikan.
                    </p>

                    <label class="flex items-center justify-center gap-3 p-4 bg-red-50 rounded-2xl border-2 border-red-100 cursor-pointer mb-8 hover:bg-red-100/50 transition-colors">
                        <input type="checkbox" x-model="confirmCheck" class="w-5 h-5 rounded border-red-300 text-red-600 focus:ring-red-500">
                        <span class="text-xs font-black text-red-700 uppercase tracking-tight">Saya sadar dan ingin menghapus semuanya</span>
                    </label>

                    <div class="flex gap-3">
                        <button @click="showDeleteModal = false" class="flex-1 py-3 px-6 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all">
                            Batal
                        </button>
                        <form :action="'{{ route('guru.jurnal.deleteAll') }}'" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" :disabled="!confirmCheck" 
                                    class="w-full py-3 px-6 bg-red-600 text-white font-bold rounded-2xl shadow-lg shadow-red-100 hover:bg-red-700 transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                                Ya, Hapus Semua
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sesi</th>
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
                    <td class="py-3 px-4 text-xs font-bold text-gray-400">#{{ $jurnal->id }}</td>
                    <td class="py-3 px-4 text-xs text-blue-500 font-mono">S-{{ $jurnal->qr_session_id }}</td>
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
@endsection
