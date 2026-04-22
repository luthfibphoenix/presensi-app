@extends('layout.app')

@section('title', 'Manajemen Mata Pelajaran')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-black text-gray-800 mb-4">Tambah Mata Pelajaran</h3>
        <form action="{{ route('admin.mapel.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="nama_mapel" placeholder="Nama Mata Pelajaran" class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-purple-500 outline-none" required>
            <button type="submit" class="bg-purple-600 text-white font-black px-6 py-2.5 rounded-xl text-xs hover:bg-purple-700 transition">
                Simpan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">No</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Mata Pelajaran</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($mapels as $m)
                <tr>
                    <td class="px-6 py-4 text-sm font-bold text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-black text-gray-800">{{ $m->nama_mapel }}</td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mapel ini?')">
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
