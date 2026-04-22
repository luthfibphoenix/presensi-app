@extends('layout.app')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-black text-gray-800 mb-4">Tambah Kelas Baru</h3>
        <form action="{{ route('kelas.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <input type="text" name="nama_kelas" placeholder="Nama Kelas (Contoh: XII RPL 1)" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-purple-500" required>
            <input type="text" name="kode_kelas" placeholder="Kode Kelas (Contoh: XII-RPL-1)" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-purple-500" required>
            <button type="submit" class="bg-purple-600 text-white font-black px-6 py-2.5 rounded-xl text-xs hover:bg-purple-700 transition uppercase tracking-widest">
                Simpan Kelas
            </button>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">No</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Kelas</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kode Kelas</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($kelases as $k)
                <tr>
                    <td class="px-6 py-4 text-sm font-bold text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-black text-gray-800">{{ $k->nama_kelas }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-purple-600">{{ $k->kode_kelas }}</td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
